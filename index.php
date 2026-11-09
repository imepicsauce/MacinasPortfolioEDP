<?php
$title = 'Home';
$page  = 'home';
$base  = '';
require __DIR__ . '/includes/header.php';
?>
	<main>

		<div id="top-page" class="herobanner">
			<h1>Graphic design. Video edits. Original music.</h1>
			<p class="hero-sub">Isaac Macinas, IT student and content creator</p>
		</div>
		
		<div class="landing">
			<img src="images/macinas_main.jpg" id="macinas_main" alt="Portrait of Isaac Macinas" width="1400" height="1400" fetchpriority="high">
			<div class="mainintro">
				<div class="hi-im">
					<h4>Hi, I'm</h4>
					<h1>Isaac Macinas</h1>
				</div>
				<div class="intro-description">
					<p>I'm an IT student at Pamantasan ng Lungsod ng Valenzuela who makes graphic designs, video edits and music, and builds the tools to go with them. Got a project? Let's make it.</p>
				</div>
				<div class="cta-row">
					<a href="#demoreel">Watch the reel</a>
					<a href="html/gallery.php">See the gallery</a>
					<a href="html/contact.php">Work with me</a>
				</div>
			</div>
		</div>

		<div class="videoarea white">
			<h1>What do I do?</h1>
			<h2>Watch my introduction reel!</h2>
			<video id="demoreel" controls preload="metadata" poster="images/demoreel-poster.jpg" src="images/Demoreelz.mp4"></video>
			<p>
				The reel shows some of my work. I'm a flexible IT student who focuses on graphic design, video editing and music production, using my software skills to deliver the best output for any project. Looking for someone skillful and creative? <a href="html/contact.php">Get in touch.</a>
			</p>
		</div>
	</main>

<?php require __DIR__ . '/includes/footer.php'; ?>
