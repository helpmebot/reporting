<?php

require_once('config.php');

$query = 'SELECT * FROM welcomelog WHERE 1=1';
$params = array();

$afterDefined = false;

if(isset($_GET['channel'])) {
	$params[] = $_GET['channel'];
	$query .= ' AND channel = ?';
}

if(isset($_GET['aftertime'])) {
	$params[] = $_GET['aftertime'];
	$query .= ' AND welcome_timestamp > ?';
	$afterDefined = true;
}

if(isset($_GET['afterid'])) {
	$params[] = $_GET['afterid'];
	$query .= ' AND id > ?';
	$afterDefined = true;
}

if(!$afterDefined) {
	echo "Please define either the aftertime parameter with a timestamp, or afterid with an integer.";
	header('HTTP/1.1 400 Bad Request');
	die();
}

$statement = $db->prepare($query);
$statement->execute($params);

header('Content-Type: application/json');
echo json_encode($statement->fetchAll(PDO::FETCH_ASSOC));