<?php
include_once("assets/analytics.php");

error_reporting(-1);
ini_set('display_errors', 'On');

include("hashids/HashGenerator.php");
include("hashids/Hashids.php");

if ($_POST['chat'] != null && $_POST['chat'] != "") {

	$config = parse_ini_file('./config/config.ini');
	$connection = mysqli_connect($config['host'], $config['username'], $config['password'], $config['dbname'], $config['port']);

    if ($connection->connect_errno) {
		echo "Could not connect to database.";
	}

    $tablename = $config['tablename'];

	$stmt = $connection->prepare("SELECT COUNT(*) FROM $tablename");
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($numid);
	$stmt->fetch();

	$hashids = new Hashids\Hashids('1e37h4x0r5', 8);
	$strid = $hashids->encode($numid);

	if (isset($_SERVER["REMOTE_ADDR"])) {
		$ip = $_SERVER["REMOTE_ADDR"];
	}

	$stmt = $connection->prepare("INSERT INTO logs (strid, log, ip) VALUES (?, ?, ?)");
	$stmt->bind_param("sss", $strid, $_POST['chat'], $ip);
	$stmt->execute();

	header("Location: " . $strid ."/");
} else {
	echo "Something went wrong :/";
}