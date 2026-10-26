<?php
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: /html/contact.html");
    exit();
}

$firstName = htmlspecialchars(trim($_POST['firstname'] ?? ''));
$lastName  = htmlspecialchars(trim($_POST['lastname'] ?? ''));
$email     = filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL);
$message   = htmlspecialchars(trim($_POST['message'] ?? ''));

if (!$email || !$firstName || !$message) {
    header("Location: /html/contact.html?status=error");
    exit();
}

$payload = json_encode([
    "from"     => "Contact Form <onboarding@resend.dev>",
    "to"       => ["isaacmacinas@gmail.com"],
    "reply_to" => $email,
    "subject"  => "New Contact Form Message from $firstName $lastName",
    "text"     => "Name: $firstName $lastName\nEmail: $email\n\nMessage:\n$message",
]);

$ch = curl_init("https://api.resend.com/emails");
curl_setopt_array($ch, [
    CURLOPT_POST           => true,
    CURLOPT_POSTFIELDS     => $payload,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER     => [
        "Authorization: Bearer " . getenv("RESEND_API_KEY"),
        "Content-Type: application/json",
    ],
]);
curl_exec($ch);
$code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

header("Location: /html/contact.html?status=" . ($code >= 200 && $code < 300 ? "success" : "error"));
exit();