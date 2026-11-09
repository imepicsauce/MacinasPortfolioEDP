<?php
/**
 * Front door for Vercel. vercel.json sends every page request here, and this
 * file loads the matching page. Static files (css, js, images, files) are
 * served by Vercel directly and never reach this script.
 *
 * To add a page: create the .php file, then add one line to $pages below
 * (and one to $nav in includes/header.php).
 */
$root = dirname(__DIR__);

// URL path => page file. Only pages listed here can be opened.
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
