<!DOCTYPE html>
<html lang="de">

<head>
	<meta charset="utf-8" />
	<title>Import</title>
</head>

<body>

<?php

require_once 'verbindungsaufbau.php';
$liste = file_get_contents("http://wortschatz.uni-leipzig.de/Papers/top10000en.txt");
$encoded = mb_convert_encoding($liste, 'UTF-8',mb_detect_encoding($liste, 'UTF-8, ISO-8859-1', true));
$wortarray = explode("\n", str_replace("'", "\'", $encoded));
$importliste = $rest = substr(implode("'),('", $wortarray), 0, -3);
if ($mysqli->query("INSERT IGNORE INTO `unileipzig-en` (wort) VALUES ('$importliste")) {
	echo "Erfolgreich importiert";
} else {
	echo "Es ist ein Fehler aufgetreten: ";
	echo $mysqli->error;
}
?>
</body>
</html>
