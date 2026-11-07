<?php
$title = 'Gallery';
$page  = 'gallery';
$base  = '../';
$scripts = ['js/projects.js']; // loaded after the footer
require __DIR__ . '/../includes/header.php';
?>
	<main>
		<div id="top-page" class="herobanner herogallery">
			<h1>My Works</h1>
		</div>

		<div class="gallerydark">
			<h1>Gallery</h1>
			<nav class="navbar" aria-label="Gallery sections">
				<a class="jump-button" href="#projects">Projects</a>
				<a class="jump-button" href="#graphic-designs">Graphic Designs</a>
				<a class="jump-button" href="#certificates">Certificates</a>
				<a class="jump-button" href="#videos">Videos</a>
			</nav>
		</div>

		<!--
			Layout note: --ar is each item's aspect ratio (width / height). Items in a
			row grow in proportion to it, so a row shares one height and fills the
			width. If you add a piece, set --ar to its pixel size, e.g. "1080 / 1350",
			and put it in a row.
		-->

		<section id="projects" class="gallery-section gallery-section--light" aria-labelledby="projects-title">
			<h2 id="projects-title">Projects</h2>
			<!-- Cards are built from the PROJECTS list in js/projects.js -->
			<ul id="project-list" class="project-list"></ul>
			<noscript>
				<p class="project-fallback">The project cards need JavaScript. You can find all of them on <a href="https://github.com/imepicsauce">my GitHub</a>.</p>
			</noscript>
		</section>

		<section id="graphic-designs" class="gallery-section" aria-labelledby="graphic-designs-title">
			<h2 id="graphic-designs-title">Graphic Designs</h2>
			<div class="gallerylist">
				<div class="gallery-row gallery-row--photo">
					<div class="gallerycard" style="--ar: 2550 / 3300">
						<img src="../images/PUZZLEEED.png" alt="Puzzled" width="2550" height="3300" loading="lazy" decoding="async">
					</div>
					<div class="gallerycard" style="--ar: 1440 / 960">
						<img src="../images/Porchse (1).png" alt="Porsche" width="1440" height="960" loading="lazy" decoding="async">
					</div>
				</div>
				<div class="gallery-row gallery-row--photo">
					<div class="gallerycard" style="--ar: 1080 / 1080">
						<img src="../images/JeriCoffee-Socmed.jpg" alt="Poster" width="1080" height="1080" loading="lazy" decoding="async">
					</div>
					<div class="gallerycard" style="--ar: 2160 / 2700">
						<img src="../images/SSS Updated Pinaka.png" alt="Secret Society Studios wordmark stamped on textured paper, with playing cards and a game controller" width="2160" height="2700" loading="lazy" decoding="async">
					</div>
					<div class="gallerycard" style="--ar: 1080 / 1920">
						<img src="../images/coffee.zip moodboard.png" alt="" width="1080" height="1920" loading="lazy" decoding="async">
					</div>
				</div>
			</div>
		</section>

		<section id="certificates" class="gallery-section gallery-section--light" aria-labelledby="certificates-title">
			<h2 id="certificates-title">Certificates</h2>
			<div class="gallerylist">
				<div class="gallery-row gallery-row--photo">
					<div class="gallerycard" style="--ar: 2048 / 1536">
						<img src="../images/sqlcertificate.jpeg" alt="SQL Certificate" width="2048" height="1536" loading="lazy" decoding="async">
					</div>
					<div class="gallerycard" style="--ar: 1754 / 1241">
						<img src="../images/simplilearn.jpg" alt="SimpliLearn Certificate" width="1754" height="1241" loading="lazy" decoding="async">
					</div>
				</div>
			</div>
		</section>

		<section id="videos" class="gallery-section gallery-section--dark" aria-labelledby="videos-title">
			<h2 id="videos-title">Video Edits + Song Covers</h2>
			<div class="gallerylist">
				<div class="gallery-row gallery-row--video">
					<div class="gallerycard" style="--ar: 1080 / 1920">
						<video controls playsinline preload="none" poster="../images/whatshappening.png" src="../images/Plvs Ccc Vlog.mp4"></video>
					</div>
					<div class="gallerycard" style="--ar: 1920 / 1080">
						<video controls playsinline preload="none" poster="../images/plvsingers.png" src="../images/Plvsorgshirt Revised.mp4"></video>
					</div>
				</div>
				<div class="gallery-row gallery-row--video">
					<div class="gallerycard" style="--ar: 1280 / 720">
						<video controls playsinline preload="none" poster="../images/panayam.png" src="../images/Group 1 Vts 2025.mp4"></video>
					</div>
					<div class="gallerycard" style="--ar: 720 / 1280">
						<video controls playsinline preload="none" poster="../images/nanaman.png" src="../images/NANAMAN - IV OF SPADES Guitar Solo Cover.mp4"></video>
					</div>
				</div>
			</div>
		</section>

</main>

<?php require __DIR__ . '/../includes/footer.php'; ?>
