<?php
if($_GET && $_GET["c"]) {

require("pip.class.php");

//Change username/password
$con = mysql_connect("localhost","xxxx","xxxx");

if (!$con) {
	die('Could not connect: ' . mysql_error());
}
mysql_select_db("tz", $con);

$result = mysql_query("select path from zonemap") or die("MySQL Error:".mysql_error());
$pointLocation = new pointLocation();
$point = explode(",",$_GET["c"])[0]." ".explode(",",$_GET["c"])[1];

while($row = mysql_fetch_array($result)) {
	$coords = explode("|",$row['path']);

	$polygon = array();
	for($i=0; $i<count($coords)-1; $i++) {
		$xy = explode(",",$coords[$i]);
		$polygon[$i] = $xy[0] . " " . $xy[1];
	}

	if($pointLocation->pointInPolygon($point, $polygon)) {
		echo $row['zone'];
	}
}

mysql_close($con);
}
else {
	echo "Please give latitude and longitude example: tz.php?c=19.725342,-155.581056";
}
?>
