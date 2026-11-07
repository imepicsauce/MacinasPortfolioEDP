<?php
/**
 * POST /send.php  (contact form handler)
 *
 * Receives the form from html/contact.php as JSON and emails it to you
 * through Resend's HTTP API using cURL. This works on free PHP hosts that
 * block SMTP/mail(), because it only needs outbound HTTPS.
 *
 * Settings live in private/config.php (copy private/config.example.php).
 * That file is git-ignored, so your API key never goes into the repo.
 */
declare(strict_types=1);

header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store');

function respond(int $status, string $message): never
{
	http_response_code($status);
	echo json_encode(['success' => $status < 400, 'message' => $message]);
	exit;
}

// A single clean line: used for anything that ends up in a subject or header.
function one_line(string $value): string
{
	return trim(preg_replace('/[\r\n]+/', ' ', $value) ?? '');
}

// Reads a form field as a string. Anything that isn't plain text becomes ''.
function field(array $data, string $key): string
{
	$value = $data[$key] ?? '';
	return is_string($value) || is_int($value) || is_float($value) ? (string) $value : '';
}

if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
	header('Allow: POST');
	respond(405, 'Method not allowed.');
}

// Only accept posts coming from this site (browsers always send Origin on a POST).
$origin = $_SERVER['HTTP_ORIGIN'] ?? '';
if ($origin !== '') {
	$parts = parse_url($origin);
	$originHost = is_array($parts) && isset($parts['host'])
		? $parts['host'] . (isset($parts['port']) ? ':' . $parts['port'] : '')
		: '';
	if (strcasecmp($originHost, $_SERVER['HTTP_HOST'] ?? '') !== 0) {
		respond(403, 'Request not allowed.');
	}
}

// The page sends JSON; a plain form post works too.
$raw = (string) file_get_contents('php://input', false, null, 0, 20000);
if (stripos($_SERVER['CONTENT_TYPE'] ?? '', 'application/json') !== false) {
	$data = json_decode($raw, true);
} else {
	$data = $_POST;
}
$data = is_array($data) ? $data : [];

// Honeypot: real visitors never tick the hidden checkbox. Pretend it worked.
if (!empty($data['botcheck'])) {
	respond(200, 'Message sent!');
}

$first   = one_line(field($data, 'firstname'));
$last    = one_line(field($data, 'lastname'));
$email   = one_line(field($data, 'email'));
$message = trim(field($data, 'message'));

if ($first === '' || $last === '' || $message === '') {
	respond(422, 'Please fill in every field.');
}
if (strlen($email) > 254 || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
	respond(422, 'That email address looks invalid.');
}
if (mb_strlen($first) > 60 || mb_strlen($last) > 60 || mb_strlen($message) > 5000) {
	respond(422, 'One of the fields is too long.');
}
if (!mb_check_encoding($first . $last . $email . $message, 'UTF-8')) {
	respond(422, 'Some characters could not be read. Please retype your message.');
}

$configFile = __DIR__ . '/private/config.php';
$config = is_file($configFile) ? require $configFile : null;
if (!is_array($config) || empty($config['resend_api_key']) || empty($config['to'])) {
	error_log('Contact form: private/config.php is missing or incomplete.');
	respond(500, "The contact form isn't set up yet. Please try again later.");
}
if (!function_exists('curl_init')) {
	error_log('Contact form: the PHP cURL extension is not enabled on this host.');
	respond(500, "The contact form isn't set up yet. Please try again later.");
}

// Best-effort spam brake: one message per visitor IP per rate_limit_seconds.
// Set rate_limit_seconds to 0 in the config to turn it off.
$cooldown = (int) ($config['rate_limit_seconds'] ?? 60);
$ip = $_SERVER['HTTP_CF_CONNECTING_IP'] ?? $_SERVER['REMOTE_ADDR'] ?? 'unknown';
$stamp = sys_get_temp_dir() . '/portfolio_contact_' . hash('sha256', $ip . '|' . $config['resend_api_key']);
if ($cooldown > 0 && is_file($stamp) && time() - (int) filemtime($stamp) < $cooldown) {
	respond(429, 'Please wait a minute before sending another message.');
}

$fullName = $first . ' ' . $last;
$payload = json_encode([
	'from'     => $config['from'] ?? 'Portfolio Contact <onboarding@resend.dev>',
	'to'       => [$config['to']],
	'reply_to' => $email, // so "Reply" in your inbox goes to the visitor
	'subject'  => mb_substr('New portfolio message from ' . $fullName, 0, 150),
	'text'     => "Name: $fullName\nEmail: $email\n\n$message",
], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

$ch = curl_init($config['api_url'] ?? 'https://api.resend.com/emails');
curl_setopt_array($ch, [
	CURLOPT_POST           => true,
	CURLOPT_POSTFIELDS     => $payload,
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_CONNECTTIMEOUT => 5,
	CURLOPT_TIMEOUT        => 8, // free hosts often cap a script at ~10 seconds
	CURLOPT_HTTPHEADER     => [
		'Authorization: Bearer ' . $config['resend_api_key'],
		'Content-Type: application/json',
	],
]);
$body = curl_exec($ch);
$status = (int) curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
$curlError = curl_error($ch);
curl_close($ch);

if ($body === false) {
	error_log('Contact form: could not reach Resend: ' . $curlError);
	respond(502, "Couldn't reach the mail service. Please try again later.");
}
if ($status < 200 || $status >= 300) {
	error_log("Contact form: Resend rejected the email ($status): $body");
	respond(502, 'Something went wrong sending your message. Please try again later.');
}

if ($cooldown > 0) {
	@touch($stamp);
}
respond(200, 'Message sent!');
