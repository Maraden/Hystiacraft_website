<?php
function date2stamp($date) {
	return getdate(strtotime($date))[0]; 
}

function stamp2date($time) {
	$search_month = array("01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12");
	$replace_month = array("Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre");

	return date("d ", $time) . str_replace($search_month, $replace_month, date("m", $time)) . date(" Y", $time);
}

function stamp2date_short($time) {
	$search_month = array("01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12");
	$replace_month = array("Janv", "Févr", "Mars", "Avril", "Mai", "Juin", "Juil", "Août", "Sept", "Octo", "Novem", "Décem");

	return date("d ", $time) . str_replace($search_month, $replace_month, date("m", $time)) . date(" Y", $time);
}

function stamp2time($time) {
	return date("H:i:s", $time);
}

function time_elapsed($time, $now) {
	$sec = abs($now - $time);
	$min = floor($sec / 60);
	$hour = floor($min / 60);
	$day = floor($hour / 24);
	$week = floor($day / 7);
	$month = floor($day / 31);
	$year = floor($day / 365);
	$return = 0;
	$prefix = null;

	if ($year >= 1) {
		$return = $year;
		$prefix = ($year <= 1) ? "an" : "ans";
	} elseif ($month >= 1) {
		$return = $month;
		$prefix = "mois";
	} elseif ($week >= 1) {
		$return = $week;
		$prefix = ($week <= 1) ? "semaine" : "semaines";
	} elseif ($day >= 1) {
		$return = $day;
		$prefix = ($day <= 1) ? "jour" : "jours";
	} elseif ($hour >= 1) {
		$return = $hour;
		$prefix = ($hour <= 1) ? "heure" : "heures";
	} elseif ($min >= 1) {
		$return = $min;
		$prefix = ($min <= 1) ? "minute" : "minutes";
	} else {
		$return = $sec;
		$prefix = ($sec <= 1) ? "seconde" : "secondes";
	}

	return $return . " " . $prefix;
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include_once "../mail/src/Exception.php";
include_once "../mail/src/PHPMailer.php";
include_once "../mail/src/SMTP.php";

function no_reply($to, $subject, $message, $errors = false) {
	$mail = new PHPMailer;

	$header = "";
	$footer = "";

	$result = null;

	try {
		$mail->SMTPDebug = $errors;
		$mail->isSMTP();
		$mail->Host = "ssl0.ovh.net";
		$mail->Port = 587;
		$mail->SMTPSecure = "tls";
		$mail->SMTPAuth = true;
		$mail->Username = "no-reply@hystiacraft.fr";
		$mail->Password = "A19341971s";
		$mail->setFrom("no-reply@hystiacraft.fr", "Hystiacraft");
		$mail->addAddress($to);
		$mail->Subject = $subject;
		$mail->Body = $header . $message . $footer;
		$mail->AltBody = strip_tags($message);
		$mail->CharSet = "UTF-8";
		$mail->SMTPOptions = array(
			"ssl" => array(
				"verify_peer" => false,
				"verify_peer_name" => false,
				"allow_self_signed" => true
			)
		);

		$result = $mail->send();
	} catch (Exception $e) {
		echo "Mail error: " . $mail->ErrorInfo;
	} finally {
		return $result;
	}
}

function is_mobile() {
	return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
}
?>