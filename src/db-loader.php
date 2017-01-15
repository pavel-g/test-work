<?php

require(__DIR__ . '/bootstrap.php');

\App\DbInit::createTables();
\App\DbInit::clearTables();

$db = \App\Db::getInstance();
$pdo = $db->getPdo();

$log = fopen('log.csv', 'r');
$browsers = fopen('browsers.csv', 'r');

$csvLength = 0;
$delimiter = '|';

$queries = array();
$queries['log'] = "
	INSERT INTO log (time, ip, source, destination)
	VALUES (:time, :ip, :source, :destination)
";
$queries['browsers'] = "
	INSERT INTO browsers (ip, name, os)
	VALUES (:ip, :name, :os)
";

if ($log !== false) {
	$statement = $db->getStatement($queries['log']);
	while(($data = fgetcsv($log, $csvLength, $delimiter)) !== false) {
		if (count($data) < 5) continue;
		$timestamp = \App\Utils::parseDateTime($data[0], $data[1]);
		$params = array(
			':time' => $timestamp->format('Y-m-d H:i:s'),
			':ip' => $data[2],
			':source' => $data[3],
			':destination' => $data[4]
		);
		$res = $statement->execute($params);
		var_dump($data);
		var_dump($res);
	}
}

if ($browsers !== false) {
	$statement = $db->getStatement($queries['browsers']);
	while(($data = fgetcsv($browsers, $csvLength, $delimiter)) !== false) {
		if (count($data) < 3) continue;
		$params = array(
			':ip' => $data[0],
			':name' => $data[1],
			':os' => $data[2]
		);
		$res = $statement->execute($params);
		var_dump($data);
		var_dump($res);
	}
}
