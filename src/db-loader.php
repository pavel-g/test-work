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
	INSERT INTO log (date, time, ip, source, destination)
	VALUES (:date, :time, :ip, :source, :destination)
";
$queries['browsers'] = "
	INSERT INTO browsers (ip, name, os)
	VALUES (:ip, :name, :os)
";

if ($log !== false) {
	$statement = $db->getStatement($queries['log']);
	while(($data = fgetcsv($log, $csvLength, $delimiter)) !== false) {
		$params = array(
			':date' => $data[0],
			':time' => $data[1],
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
