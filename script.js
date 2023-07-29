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

function displayDivInfo(text){
    if(text){
        //Détection du navigateur
        is_ie = (navigator.userAgent.toLowerCase().indexOf("msie") != -1) && (navigator.userAgent.toLowerCase().indexOf("opera") == -1);
         
        //Création d'une div provisoire
        var divInfo = document.createElement('div');
        divInfo.className = "bulle";
        divInfo.style.position = 'absolute';
        document.onmousemove = function(e){
            x = (!is_ie ? e.pageX-window.pageXOffset : event.x+document.body.scrollLeft);
            y = (!is_ie ? e.pageY-window.pageYOffset : event.y+document.body.scrollTop);
            divInfo.style.left = x+15+'px';
            divInfo.style.top = y+15+'px';
        }
        divInfo.id = 'divInfo';
        divInfo.innerHTML = text;
        document.body.appendChild(divInfo);
    }
    else{
        document.onmousemove = '';
        document.body.removeChild(document.getElementById('divInfo'));
    }
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
var fetch = "67797883797669";
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

