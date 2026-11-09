<?php
$root = dirname(__DIR__);

$pages = [
	'/'                  => 'index.php',
	'/index.php'         => 'index.php',
	'/html/about.php'    => 'html/about.php',
	'/html/gallery.php'  => 'html/gallery.php',
	'/html/contact.php'  => 'html/contact.php',
];

$path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
$path = $path === '/' ? '/' : rtrim($path, '/');

if (!isset($pages[$path])) {
	http_response_code(404);
	header('Content-Type: text/plain; charset=utf-8');
	echo "404 - Page not found";
	exit;
}

chdir($root);
require $root . '/' . $pages[$path];
