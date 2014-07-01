<!DOCTYPE html>
<html lang="de">

<head>
	<meta charset="utf-8" />
	<title>haupt</title>
</head>

<body>

<?php
$falscheswort ="langes wort";
if(isset($_GET["wort"])) {
	$falscheswort =$_GET["wort"];
}
$tabellen = array();
if(isset($_GET["ul-de"])) {
	$tabellen[] = "unileipzig-de";
}
if(isset($_GET["ul-en"])) {
	$tabellen[] = "unileipzig-en";
}
if(isset($_GET["nm"])) {
	$tabellen[] = "netzmafia";
}
require_once 'verbindungsaufbau.php';
foreach ($tabellen as $tabelle) {
	$vorhanden = $mysqli->query("SELECT id FROM `$tabelle` WHERE wort='$falscheswort'");
	if($vorhanden->num_rows == 1) {
		echo "<p><strong>Das Wort ist richtig</strong></p>";
		exit;
	}
	$vorhanden->close();
}
$arrayahnlich =array(); // leeres Array erstellen

foreach ($tabellen as $tabelle) {
	$ergebnis = $mysqli->query("SELECT wort FROM `$tabelle`");
//	echo "<table border='1'>\n";
	while ($wort = $ergebnis->fetch_array()) { 
		$ahnlichkeit=similar_text($falscheswort, $wort[0]);
//		echo "<tr><td>$wort[0]</td><td>$ahnlichkeit</td></tr>";
		$arrayahnlich[$wort[0]] = $ahnlichkeit;
	}
	$ergebnis->close();
//	echo "</table>";
}
asort($arrayahnlich);
$top = array_keys($arrayahnlich);
echo "$top[0],$top[1],$top[2],$top[3]";
print_r($top);
?>
</table>
</body>
</html>
