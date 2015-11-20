<?php
include_once("assets/analytics.php");

error_reporting(-1);
ini_set('display_errors', 'On');

include("hashids/HashGenerator.php");
include("hashids/Hashids.php");

if ($_POST['chat'] != null && $_POST['chat'] != "") {
	$mysqli = new mysqli();
	if ($mysqli->connect_errno) {
		echo "Could not connect to database.";
	}
	$stmt = $mysqli->prepare("SELECT COUNT(*) FROM logs");
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($numid);
	$stmt->fetch();

	$hashids = new Hashids\Hashids('1e37h4x0r5', 8);
	$id = $hashids->encode($numid);

	if (isset($_SERVER["REMOTE_ADDR"])) {
		$ip = $_SERVER["REMOTE_ADDR"];
	}

	$stmt = $mysqli->prepare("INSERT INTO logs(strid, log, ip) VALUES (?, ?, ?)");
	$stmt->bind_param("sss", $id, $_POST['chat'], $ip);
	$stmt->execute();

	header("Location: " . $id ."/");
}
else {
	echo "Something went wrong :/";
}