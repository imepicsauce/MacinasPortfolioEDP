/* ==========================================================================
   Projects (shown on the Gallery page)

   To add a project, copy one { ... } block in PROJECTS, paste it after the
   last one (keep a comma between blocks) and edit the text:

     title        Project name
     description  One or two sentences
     image        Path to a screenshot, relative to html/gallery.html.
                  3:2 landscape (e.g. 960 x 640) fits the card best.
     imageAlt     What the screenshot shows, for screen readers
     tags         Short labels for the tech used
     links        Buttons: { label: "...", url: "..." }. The first one is the
                  main button; later ones are drawn as outlined buttons.

   Cards appear in the same order as this list.
   ========================================================================== */

const PROJECTS = [
	{
		title: "TableBench",
		description:
			"A browser-based 3D visualizer for board-game boards and cards. " +
			"Set real-world sizes, drop in your artwork, pick a surface finish " +
			"(matte, glossy, textured or holographic) and look at it on a virtual " +
			"table, with orbit and cinematic freecam camera moves.",
		image: "../images/tablebench.jpg",
		imageAlt:
			"TableBench: a controls panel on the left and a 3D game board with a card on a virtual table on the right",
		tags: ["HTML", "CSS", "JavaScript", "three.js"],
		links: [
			{ label: "Live demo", url: "https://imepicsauce.github.io/tablebench/" },
			{ label: "View on GitHub", url: "https://github.com/imepicsauce/tablebench" }
		]
	}
];

/* --------------------------------------------------------------------------
   Rendering. You shouldn't need to edit anything below this line.
   -------------------------------------------------------------------------- */

(function renderProjects() {
	const list = document.getElementById("project-list");
	if (!list) return;

	// Builds an element and sets its text safely (no HTML is parsed).
	function make(tag, className, text) {
		const node = document.createElement(tag);
		if (className) node.className = className;
		if (text) node.textContent = text;
		return node;
	}

	PROJECTS.forEach(function (project) {
		const item = make("li");
		const card = make("article", "project-card");

		if (project.image) {
			const img = make("img");
			img.src = project.image;
			img.alt = project.imageAlt || "";
			img.loading = "lazy";
			img.decoding = "async";
			card.append(img);
		}

		const body = make("div", "project-body");
		body.append(make("h3", "", project.title), make("p", "", project.description));

		if (project.tags && project.tags.length) {
			const tags = make("ul", "project-tags");
			project.tags.forEach(function (tag) {
				tags.append(make("li", "", tag));
			});
			body.append(tags);
		}

		if (project.links && project.links.length) {
			const links = make("div", "project-links");
			project.links.forEach(function (link) {
				const a = make("a", "", link.label);
				a.href = link.url;
				a.target = "_blank";
				a.rel = "noopener noreferrer";
				a.setAttribute("aria-label", link.label + " (" + project.title + ")");
				links.append(a);
			});
			body.append(links);
		}

		card.append(body);
		item.append(card);
		list.append(item);
	});
})();
