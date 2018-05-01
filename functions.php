<?php

/*Requête GET avec cURL*/
function grab_page($site){
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
	curl_setopt($ch, CURLOPT_TIMEOUT, 40);
	curl_setopt($ch, CURLOPT_HEADER, true);
	curl_setopt($ch, CURLOPT_URL, $site);
	ob_start();
	return curl_exec ($ch);
	ob_end_clean();
	curl_close ($ch);
}


/*Retourne la donnée demandée en paramètre d'une date au format ISO 8601
exemple : 20180524T083000Z
https://en.wikipedia.org/wiki/ISO_8601
 */
function convertDate($str = "", $type = "day", $timezone = "Europe/Paris") {
	date_default_timezone_set($timezone);

	if ($type == "day")
		$date = date("d-m-Y", strtotime($str));
	elseif ($type == "hour")
		$date = date("H\hi", strtotime($str));
	elseif ($type == "timestamp")
		$date = strtotime($str);
	else
		$date = "";

	return $date;
}


/*Extrait les données d'un fichier .ICS*/ 
function extractData($str = "") {
	$data = [];

	/*Date de début du cours*/
	preg_match("/DTSTART\:(.*?)\\n/", $str, $x);
	$data["coursDate"] = convertDate($x[1], "day");
	$data["coursDebut"] = convertDate($x[1], "hour");

	/*Date de fin du cours*/
	preg_match("/DTEND\:(.*?)\\n/", $str, $x);
	$data["coursFin"] = convertDate($x[1], "hour");

	/*Nom du cours*/
	preg_match("/SUMMARY\:(.*?)\\n/", $str, $x);
	$data["coursNom"] = $x[1];

	/*Lieu du cours*/
	preg_match("/LOCATION\:(.*?)\\n/", $str, $x);
	$data["coursSalle"] = $x[1];

	/*Groupe de TD/TP du cours*/
	preg_match('/DESCRIPTION\:(.*?)\\n/', $str, $x);
	$x = explode('\n', $x[0]);
	$data["coursGroupe"] = $x[1];

	/*Gère si il n'y a pas de professeur*/
	if (!preg_match("/Export/", $x[2]))
		$data["coursProf"] = $x[2];
	else
		$data["coursProf"] ="";
	
	return $data;
}


/*Récupère le planning, fonction principale*/
function getPlanningIut($url, $type = "jsonIndent") {
	/*
	$type = "array"			<- Retourne tableau des plannings format tableau PHP
	$type = "json"			<- Retourne tableau des plannings format json
	$type = "jsonIndent"	<- Retourne tableau des plannings format json lisible
	*/

	$planning = [];
	
	$result = grab_page($url);

	preg_match_all("/BEGIN:VEVENT[\s\S]*?END:VEVENT/", $result, $extract);

	foreach ($extract[0] as $key => $value) {
		$data = extractData($value);
		array_push($planning, $data);
	}

	if ($type == "array") {
		return $planning;
	}
	elseif ($type == "json") {
		return json_encode($planning);
	}
	elseif ($type == "jsonIndent") {
		return json_encode($planning, JSON_PRETTY_PRINT);
	}
	return $planning;
}

/*Enregistrer dans un fichier*/
function saveToFile($fileName, $data) {
	file_put_contents($fileName, $data);
}

?>