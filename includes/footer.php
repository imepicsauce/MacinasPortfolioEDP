<?php
/**
 * Shared bottom of every page: footer, optional scripts, closing tags.
 *
 * Uses $base from the page (see header.php). A page can set
 * $scripts = ['js/something.js']; before including this file to load
 * extra scripts after the footer.
 */
$base    = $base ?? '';
$scripts = $scripts ?? [];
?>
	<footer>
		<div class="logobanner">
			<img src="<?= $base ?>images/mainlogo-light.png" id="mainlogo">

			<div class="credits">
				<p>Designed and Developed by Isaac Derek N. Macinas from BSIT 3-4</p>
			</div>
		</div>
		<div class="credits">
			<p>© Copyright <?= date('Y') ?></p>
		</div>
	</footer>
<?php foreach ($scripts as $src): ?>
	<script src="<?= $base . $src ?>"></script>
<?php endforeach; ?>
</body>
</html>
