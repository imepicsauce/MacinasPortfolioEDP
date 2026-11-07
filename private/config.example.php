<?php
/**
 * Contact form settings.
 *
 * 1. Copy this file to private/config.php (same folder).
 * 2. Fill in your real values.
 * 3. Upload private/config.php to the host yourself. It is git-ignored on
 *    purpose, so the API key is never committed to the public repo.
 *
 * This file only returns settings and prints nothing, so even if someone
 * opened it in a browser they would see a blank page, and .htaccess in this
 * folder blocks direct access as well.
 */
return [
	// From resend.com -> API Keys
	'resend_api_key' => 're_xxxxxxxxxxxxxxxxxxxxxxxx',

	// Where contact messages are delivered
	'to' => 'you@example.com',

	// Needs a domain verified in Resend, e.g. 'Portfolio <contact@yourdomain.com>'.
	// Resend's test sender below only delivers to the email you signed up to Resend with.
	'from' => 'Portfolio Contact <onboarding@resend.dev>',

	// One message per visitor IP per this many seconds. 0 turns it off.
	'rate_limit_seconds' => 60,
];
