/**
 * POST /api/contact  (Vercel serverless function)
 *
 * Receives the contact form from html/contact.html as JSON and emails it to
 * you through Resend. The Resend API key lives only here, on the server.
 *
 * Environment variables (set them in Vercel -> Project -> Settings ->
 * Environment Variables; see .env.example):
 *   RESEND_API_KEY       required. Your Resend API key. Never commit it.
 *   CONTACT_TO_EMAIL     required. Where messages are delivered.
 *   CONTACT_FROM_EMAIL   optional. "Name <address@your-verified-domain>".
 *                        Defaults to Resend's test sender, which can only
 *                        deliver to the email you signed up to Resend with.
 */

const MAX_NAME = 60;
const MAX_EMAIL = 254;
const MAX_MESSAGE = 5000;
const COOLDOWN_MS = 60 * 1000;

// Best-effort spam brake: one message per minute per IP. Serverless instances
// each have their own memory, so this slows casual spam but is not airtight.
// For real protection, add Vercel's Firewall rate limit or Cloudflare Turnstile.
const lastSent = new Map();

function reply(res, status, success, message) {
	res.setHeader("Cache-Control", "no-store");
	return res.status(status).json({ success, message });
}

// Single-line text for anything that ends up in a header or subject.
function oneLine(value) {
	return String(value ?? "").replace(/[\r\n]+/g, " ").trim();
}

function readBody(req) {
	let body = req.body;
	if (typeof body === "string") {
		try {
			body = JSON.parse(body);
		} catch {
			body = null;
		}
	}
	return body && typeof body === "object" ? body : {};
}

module.exports = async function handler(req, res) {
	if (req.method !== "POST") {
		res.setHeader("Allow", "POST");
		return reply(res, 405, false, "Method not allowed.");
	}

	// Only accept posts coming from this site (browsers always send Origin on a POST).
	const origin = req.headers.origin;
	if (origin) {
		let originHost = "";
		try {
			originHost = new URL(origin).host;
		} catch {}
		if (originHost !== req.headers.host) {
			return reply(res, 403, false, "Request not allowed.");
		}
	}

	const body = readBody(req);

	// Honeypot: real visitors never tick the hidden checkbox. Pretend it worked.
	if (body.botcheck) return reply(res, 200, true, "Message sent!");

	const first = oneLine(body.firstname);
	const last = oneLine(body.lastname);
	const email = oneLine(body.email);
	const message = String(body.message ?? "").trim();

	if (!first || !last || !message) {
		return reply(res, 422, false, "Please fill in every field.");
	}
	if (email.length > MAX_EMAIL || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
		return reply(res, 422, false, "That email address looks invalid.");
	}
	if (first.length > MAX_NAME || last.length > MAX_NAME || message.length > MAX_MESSAGE) {
		return reply(res, 422, false, "One of the fields is too long.");
	}

	const apiKey = process.env.RESEND_API_KEY;
	const to = process.env.CONTACT_TO_EMAIL;
	const from = process.env.CONTACT_FROM_EMAIL || "Portfolio Contact <onboarding@resend.dev>";
	if (!apiKey || !to) {
		console.error("Contact form is missing RESEND_API_KEY or CONTACT_TO_EMAIL.");
		return reply(res, 500, false, "The contact form isn't set up yet. Please try again later.");
	}

	const ip = req.headers["x-real-ip"] || String(req.headers["x-forwarded-for"] || "").split(",")[0].trim() || "unknown";
	const now = Date.now();
	if (now - (lastSent.get(ip) || 0) < COOLDOWN_MS) {
		return reply(res, 429, false, "Please wait a minute before sending another message.");
	}

	const fullName = `${first} ${last}`;
	let response;
	try {
		response = await fetch("https://api.resend.com/emails", {
			method: "POST",
			headers: {
				Authorization: `Bearer ${apiKey}`,
				"Content-Type": "application/json"
			},
			body: JSON.stringify({
				from,
				to: [to],
				reply_to: email, // so "Reply" in your inbox goes to the visitor
				subject: `New portfolio message from ${fullName}`.slice(0, 150),
				text: `Name: ${fullName}\nEmail: ${email}\n\n${message}`
			}),
			signal: AbortSignal.timeout(10000)
		});
	} catch (err) {
		console.error("Resend request failed:", err.message);
		return reply(res, 502, false, "Couldn't reach the mail service. Please try again later.");
	}

	if (!response.ok) {
		console.error("Resend rejected the email:", response.status, await response.text());
		return reply(res, 502, false, "Something went wrong sending your message. Please try again later.");
	}

	lastSent.set(ip, now);
	if (lastSent.size > 500) {
		for (const [key, time] of lastSent) {
			if (now - time > COOLDOWN_MS) lastSent.delete(key);
		}
	}
	return reply(res, 200, true, "Message sent!");
};
