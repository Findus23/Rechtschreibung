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
require_once 'verbindungsaufbau.php';
$vorhanden = $mysqli->query("SELECT id FROM `unileipzig-en`,`unileipzig-de` WHERE wort='$falscheswort'");
if($vorhanden->num_rows ==1) {
	echo "<p><strong>Das Wort ist richtig</strong></p>";
	exit;
}
$ergebnis = $mysqli->query("SELECT wort FROM `unileipzig-en`,`unileipzig-de`");
// echo "<table border='1'>\n";
$arrayahnlich =array(); // leeres Array erstellen
while ($wort = $ergebnis->fetch_array()) { 
	$ahnlichkeit=levenshtein($falscheswort, $wort[0]);
//	echo "<tr><td>$wort[0]</td><td>$ahnlichkeit</td></tr>";
	$arrayahnlich[$wort[0]] = $ahnlichkeit;
}
asort($arrayahnlich);
$top = array_keys($arrayahnlich);
echo "$top[0],$top[1],$top[2],$top[3]";

?>
</table>
</body>
</html>
