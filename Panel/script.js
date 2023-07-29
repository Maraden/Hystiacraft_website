function $($str) {
	return document.querySelector($str);
}

function $a($str) {
	return document.querySelectorAll($str);
}

var menu = false

$(".value-button").addEventListener("click", () => {
	menu = !menu;

	var vmenu = $(".value-menu");

	if (menu) {
		vmenu.style.fontSize = "initial";
		setTimeout(() => {
			vmenu.style.opacity = "1";
		}, 500);
	} else {
		vmenu.style.opacity = "0";
		setTimeout(() => {
			vmenu.style.fontSize = "0px";
		}, 500);
	}
});

for (b of $a(".value-menu-button")) {
	if (localStorage.getItem(b.getAttribute("value")) == undefined) localStorage.setItem(b.getAttribute("value"), 1);

	if (localStorage.getItem(b.getAttribute("value")) == 0) {
		b.className = b.className.replace("display", "hide");

		for (v of $a(".value-" + b.getAttribute("value"))) {
			v.style.pointerEvents = "none";
			v.style.width = "0";
			v.style.opacity = "0";
		}
	}

	b.addEventListener("click", event => {
		var t = event.currentTarget;

		if (t.className.split(" ").includes("display")) {
			t.className = t.className.replace("display", "hide");
			localStorage.setItem(t.getAttribute("value"), 0);

			for (v of $a(".value-" + t.getAttribute("value"))) {
				v.style.pointerEvents = "none";
				v.style.position = "absolute";
				v.style.opacity = "0";
			}
		} else {
			t.className = t.className.replace("hide", "display");
			localStorage.setItem(t.getAttribute("value"), 1);

			for (v of $a(".value-" + t.getAttribute("value"))) {
				v.style.pointerEvents = null;
				v.style.position = null;
				v.style.opacity = null;
			}
		}
	});
}

for (b of $a(".edit")) {
	b.addEventListener("dblclick", event => {
		display();

		var t = event.currentTarget;
		var tc = t.cloneNode(true);
		t.parentNode.replaceChild(tc, t);

		tc.innerHTML = "<input type=\"text\" name=\"" + t.className.split(" ")[2] + "\" value=\"" + t.innerHTML + "\" placeholder=\"" + t.innerHTML + "\">";
	});
}

function display() {
	$(".edited").style.display = "block";
	$(".nav").style.display = "none";
}