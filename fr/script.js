if (localStorage.getItem("first_join") == null) {
	localStorage.setItem("first_join", true);

	var h = document.querySelector("header .brand .header");
	h.style.top = "30%";
	h.style.zIndex = "1000";
	h.style.transition = "1s";

	var b = document.createElement("div");
	b.style.width = "100%";
	b.style.height = "100%";
	b.style.position = "fixed";
	b.style.top = "0px";
	b.style.left = "0px";
	b.style.transition = "1s";
	b.style.background = "#00000000";
	b.style.zIndex = "999";

	document.body.appendChild(b);

	setTimeout(function() {
		h.style.transition = null;
		b.style.background = "#000000BB";
		h.style.transform = "rotateY(-1turn)";

		setTimeout(function() {
			h.style.transition = "3s";
			h.style.transform = null;

			setTimeout(function() {
				h.style.transition = "1s";
			}, 1000);
		}, 1000);

		setTimeout(function() {
			b.style.background = "#00000000";
			h.style.top = null;

			setTimeout(function() {
				h.style.transform = null;
				h.style.transition = null;
				document.body.removeChild(b);
			}, 1000);
		}, 5000);
	}, 100);
}

function floaticon() {
	var fi = document.querySelector(".floaticon");

	if (window.scrollY >= 244) {
		fi.className = "floaticon floaticon-fixed";
	} else {
		fi.className = "floaticon";
	}
}

document.addEventListener("scroll", floaticon);

var letters = "";
var fetch = "798069783280768571767378693267797883797669";
var found = false;
var console_shown = false;

if (sessionStorage.getItem("console") == fetch) {
	found = true;
	console_show();
}

function letter(e) {
	if (found) return;

	letters += e.keyCode;

	if (fetch.startsWith(letters)) {
		if (letters == fetch) {
			sessionStorage.setItem("console", letters);
			console_show();
			letters = "";
		}
	} else letters = "";
}

document.addEventListener("keydown", event => {letter(event)});

function console_show() {
	if (sessionStorage.getItem("console") == fetch) {
		if (!console_shown) {
			console_shown = true;
			var cons = document.createElement("div");
			cons.className = "console";

			var history = document.createElement("div");
			history.className = "history";

			var input = document.createElement("div");
			input.className = "input";
			input.innerHTML = "&gt; $ <input id=\"command\" type=\"text\" name=\"command\" form=\"console\" autofocus autocomplete=\"off\">";

			var form = document.createElement("form");
			form.id = "console";
			form.method = "post";
			form.setAttribute("onsubmit", "comm();return false;");
			form.innerHTML = "<button>Ok</button>";

			cons.appendChild(history);
			cons.appendChild(input);
			cons.appendChild(form);

			document.body.appendChild(cons);

			setTimeout(function() {
				input.childNodes[1].focus();
			}, 500);
		}
	}
}

function console_hide() {
	console_shown = false;
	var cons = document.querySelector(".console");

	if (cons != null) {
		cons.parentNode.removeChild(cons);
		sessionStorage.removeItem("console");
	}
}

function comm() {
	var com = document.querySelector(".console .input #command");

	if (com == null) return;

	var command = com.value;
	var history = document.querySelector(".console .history");

	var commands = command.split(";");

	history.innerHTML += "<div>$ " + command + "</div>";

	com.value = "";

	for (cmds in commands) {
		let cmd = commands[cmds].trim();
		let args = cmd.split(" ");
		if (args.length >= 1) {
			if (args[0].toLowerCase() == "exit") {
				console_hide();
			} else if (args[0].toLowerCase() == "help") {
				history.innerHTML += "<div>- <b>alert &lt;message&gt;</b> pour afficher un message d'alerte</div>";
				history.innerHTML += "<div>- <b>clear</b> pour effacer l'historique des commandes</div>";
				history.innerHTML += "<div>- <b>exit</b> pour quitter la console</div>";
				history.innerHTML += "<div>- <b>help</b> pour afficher ce menu</div>";
				history.innerHTML += "<div>- <b>open &lt;page&gt;</b> pour ouvrir une page</div>";
				history.innerHTML += "<div>- <b>reload [cache|full]</b> pour recharger la page</div>";
			} else if (args[0].toLowerCase() == "alert") {
				if (args.length > 1) {
					history.innerHTML += "<div>" + args.slice(1).join(" ") + "</div>";
					alert(args.slice(1).join(" "));
				} else history.innerHTML += "<div>Utilisez <b>" + args[0] + " &lt;message&gt;</b></div>";
			} else if (args[0].toLowerCase() == "open") {
				if (args.length > 1) {
					history.innerHTML += "<div>Ouverture de la page <u>" + args[1] + "</u>...</div>";
					window.location = args[1];
				} else history.innerHTML += "<div>Utilisez <b>" + args[0] + " &lt;page&gt;</b></div>";
			} else if (args[0].toLowerCase() == "clear") {
				history.innerHTML = "";
			} else if (args[0].toLowerCase() == "reload") {
				if (args.length > 1) {
					if (args[1].toLowerCase() == "cache") {
						history.innerHTML = "<div>Rechargement de la page...</div>";
						window.refresh();
					} else if (args[1].toLowerCase() == "full") {
						history.innerHTML = "<div>Rechargement complet de la page...</div>";
						window.refresh(true);
					} else {
						history.innerHTML += "<div>Utilisez <b>" + args[0] + " [cache|full]</b></div>";
					}
				} else {
					history.innerHTML = "<div>Rechargement de la page...</div>";
					window.refresh();
				}
			} else {
				history.innerHTML += "<div>Commande <b>" + args[0] + "</b> inconnue, utilisez la commande <b>help</b> pour voir la liste des commandes</div>";
			}
		}
	}
}