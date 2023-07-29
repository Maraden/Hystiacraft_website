<?php
class Head {
	private $title, $img, $color;

	function __construct($title = null, $img = "../images/plugline-favicon.png", $color = "#FF8800") {
		if ($title == null) $this->title = "Hystiacraft";
		else $this->title = $title . " - Hystiacraft";
		$this->img = $img;
		$this->color = $color;
	}

	function getTitle() {return $this->title;}
	function getImage() {return $this->img;}
	function getColor() {return $this->color;}

	function setTitle($title = null) {
		if ($title == null) $this->title = "Hystiacraft";
		else $this->title = $title . " - Hystiacraft";
	}

	function setImage($title = "../images/plugline-favicon.png") {$this->img = $img;}
	function setColor($color = "#FF8800") {$this->color = $color;}

	function toString() {
		$head = "<title>$this->title</title>
		<meta charset=\"utf-8\">
		<meta name=\"theme-color\" content=\"$this->color\">
		<link rel=\"icon\" href=\"$this->img\">
";

		return $head;
	}
}
?>