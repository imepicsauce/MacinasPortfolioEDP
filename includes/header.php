<?php
/**
 * Shared top of every page: <head>, logo and navigation.
 *
 * Set these variables before including this file:
 *   $title  Page name for the <title> tag, e.g. "About"
 *   $page   Which nav item is current: home | about | gallery | contact
 *   $base   Path from the page back to the site root:
 *           '' for index.php, '../' for the pages inside html/
 *
 * To add a page to the menu, add one line to $nav below.
 */
$title = $title ?? 'Home';
$page  = $page ?? 'home';
$base  = $base ?? '';
$pagesFolder = $base === '' ? 'html/' : '';

$nav = [
	'home'    => ['HOME',    $base . 'index.php'],
	'about'   => ['ABOUT',   $pagesFolder . 'about.php'],
	'gallery' => ['GALLERY', $pagesFolder . 'gallery.php'],
	'contact' => ['CONTACT', $pagesFolder . 'contact.php'],
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title><?= htmlspecialchars($title, ENT_QUOTES, 'UTF-8') ?> | Isaac Macinas</title>
	<link rel="icon" type="image/x-icon" href="<?= $base ?>favicon.ico">
	<link rel="stylesheet" href="<?= $base ?>css/style.css">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100..900&family=PT+Serif&display=swap" rel="stylesheet">
</head>

<body>
	<header>
		<div class="logobanner">
			<img src="<?= $base ?>images/mainlogo.png" id="mainlogo">
			<h1>Isaac Macinas</h1>
		</div>
		<div class="navbar">
<?php foreach ($nav as $key => [$label, $href]): ?>
			<a href="<?= $key === $page ? '#top-page' : $href ?>"><?= $label ?></a>
<?php endforeach; ?>
		</div>
	</header>

