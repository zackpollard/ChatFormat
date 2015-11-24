<?php
include("../../hashids/HashGenerator.php");
include("../../hashids/Hashids.php");

$config = parse_ini_file('../../config/config.ini');
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

$json_data = file_get_contents('php://input');

if($json_data != null) {

    $json_object = json_decode($json_data, true);

    if ($json_object) {

        if ($json_object['type']) {

            if ($json_object['messages']) {

                $stmt = $connection->prepare("INSERT INTO logs (strid, log, ip) VALUES (?, ?, ?)");
                $stmt->bind_param("sss", $strid, $json_data, $ip);
                if ($stmt->execute()) {

                    echo(json_encode(array('ok' => true, 'response' => array('id' => $strid))));
                } else {

                    echo(json_encode(array('ok' => false, 'error' => 'There was an error on the backend, contact the site administrator.')));
                }
            } else {

                echo(json_encode(array('ok' => false, 'error' => 'The JSON content contained no messages.')));
            }
        } else {

            echo(json_encode(array('ok' => false, 'error' => 'The JSON content contained no type')));
        }
    } else {

        echo(json_encode(array('ok' => false, 'error' => 'The JSON contained no content.')));
    }
} else {

    echo(json_encode(array('ok' => false, 'error' => 'No JSON object was provided.')));
}