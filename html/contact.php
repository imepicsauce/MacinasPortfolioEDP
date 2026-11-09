<?php
$title = 'Contact';
$page  = 'contact';
$base  = '../';
require __DIR__ . '/../includes/header.php';
?>
	<main>

		<div id="top-page" class="herobanner herocontact">
			<h1>Let's get in touch!</h1>
		</div>
		
		<div class="contactarea">
			<div class="form-container">
				<div class="contact-info">
					<h2>Want to work with me?</h2>
					<p>I'm open to create something with you! If you also have suggestions or anything you want to talk about, just leave a message here or contact me through my socials!</p>
					<div class="icon-row">
						<a href="https://mail.google.com/mail/?view=cm&fs=1&to=isaacmacinas@gmail.com" target="_blank" rel="noopener noreferrer">
							<img id="gmail" src="../images/gmail.png" alt="">
						</a>
						<p id="email">isaacmacinas@gmail.com</p>

						<a class="download" href="../files/Macinas_CV.pdf" download="Macinas_CV">
							Download my CV
						</a>
					</div>
					<div class="icon-row">
						<a href="https://www.facebook.com/macinas.isaac" target="_blank" rel="noopener noreferrer">
							<img id="fb" src="../images/facebook.png" alt="">
						</a>
						
						<a href="https://www.instagram.com/isaacmacinas/" target="_blank" rel="noopener noreferrer">
							<img id="ig" src="../images/instagram.png" alt="">
						</a>

						<a href="https://www.youtube.com/@isaacmacinas" target="_blank" rel="noopener noreferrer">
							<img id="yt" src="../images/youtube.png" alt="">
						</a>
					</div> 
				</div>
				<div class="contact-form">
					<form id="contact-form">
						<input type="hidden" name="access_key" value="b01e742f-ed5a-44af-a0f0-ab593ee37892">
						<input type="hidden" name="subject" value="New Contact Form Message">
						<input type="hidden" name="from_name" value="Portfolio Contact Form">
						<input type="checkbox" name="botcheck" style="display:none" tabindex="-1" autocomplete="off">

						<label for="firstname">First Name</label>
						<input type="text" name="firstname" id="firstname" required placeholder="First Name">

						<label for="lastname">Last Name</label>
						<input type="text" name="lastname" id="lastname" required placeholder="Last Name">

						<label for="email-input">Email</label>
						<input type="email" name="email" id="email-input" required placeholder="example@email.com">

						<label for="message">Message</label>
						<textarea name="message" id="message" rows="5" required placeholder="Message..."></textarea>

						<button id="submit" type="submit">SEND</button>
					</form>
				</div>
			</div>
		</div>
		
	</main>

	<div id="popup" class="popup">
		<div class="popup-content" role="alertdialog" aria-modal="true" aria-labelledby="popup-title" aria-describedby="popup-message">
			<div class="popup-icon" aria-hidden="true">
				<svg class="icon-success" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12.5l4.5 4.5L19 7.5"/></svg>
				<svg class="icon-error" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M6 6l12 12M18 6L6 18"/></svg>
			</div>
			<h2 id="popup-title"></h2>
			<p id="popup-message"></p>
			<button type="button" onclick="closePopup()">OK</button>
		</div>
	</div>

	<script>
	const popup = document.getElementById("popup");

	function closePopup() {
		popup.classList.remove("open");
		document.getElementById("submit").focus();
	}

	function showPopup(ok, title, message) {
		popup.classList.toggle("is-error", !ok);
		document.getElementById("popup-title").textContent = title;
		document.getElementById("popup-message").textContent = message;
		popup.classList.add("open");
		popup.querySelector("button").focus();
	}

	popup.addEventListener("click", (e) => {
		if (e.target === popup) closePopup();
	});

	document.addEventListener("keydown", (e) => {
		if (e.key === "Escape" && popup.classList.contains("open")) closePopup();
	});

	document.getElementById("contact-form").addEventListener("submit", async (e) => {
		e.preventDefault();
		const form = e.target;
		const btn = document.getElementById("submit");
		btn.disabled = true;
		btn.innerText = "SENDING...";

		try {
			const res = await fetch("https://api.web3forms.com/submit", {
				method: "POST",
				headers: { "Content-Type": "application/json", "Accept": "application/json" },
				body: JSON.stringify(Object.fromEntries(new FormData(form)))
			});
			const data = await res.json();

			if (data.success) {
				showPopup(true, "Message sent", "Thanks for reaching out. I'll get back to you soon.");
				form.reset();
			} else {
				showPopup(false, "Message not sent", "Something went wrong on the way. Please try again in a moment.");
			}
		} catch (err) {
			showPopup(false, "Message not sent", "Something went wrong on the way. Please try again in a moment.");
		}

		btn.disabled = false;
		btn.innerText = "SEND";
	});
	</script>


<?php require __DIR__ . '/../includes/footer.php'; ?>
