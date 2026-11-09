/* Projects (shown on the Gallery page) */

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
	},
	{
		title: "DewIt",
		description:
			"A calm, simple to-do app. Add, edit and complete tasks, filter by " +
			"what is left or done, and undo a mistake. Tasks are saved locally in your " +
			"browser, and a built-in player loads a YouTube link as a focus " +
			"soundtrack while you work.",
		image: "../images/dewit.jpg",
		imageAlt:
			"DewIt: a task list with one completed item on the left and a focus soundtrack player on the right",
		tags: ["HTML", "CSS", "JavaScript"],
		links: [
			{ label: "View on GitHub", url: "https://github.com/imepicsauce/Dewit" }
		]
	}
];

(function renderProjects() {
	const list = document.getElementById("project-list");
	if (!list) return;

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
