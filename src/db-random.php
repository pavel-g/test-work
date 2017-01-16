<?php

require(__DIR__ . '/bootstrap.php');

use \Ulrichsg\Getopt\Getopt;
use \Ulrichsg\Getopt\Option;

$getopt = new Getopt(array(
	new Option(null, 'count', Getopt::REQUIRED_ARGUMENT)
));

$getopt->parse();

$count = $getopt->getOption('count');

if (is_numeric($count)) {
	$count = (integer) $count;
} else {
	$count = 100;
}

\App\DbInit::createTables();
\App\DbInit::clearTables();

$datetimeFormat = 'Y-m-d H:i:s';

$ips = array();

for( $i = 1; $i <= $count / 10; $i++ ) {
	$ips[] = '192.168.0.' . $i;
}

$internet = array(
	'google.com',
	'yandex.ru',
	'tass.ru',
	'vk.com',
	'ok.ru',
	'wikipedia.org',
	'habrahabr.ru',
	'geektimes.ru',
	'linux.org.ru',
	'php.net',
	'developer.mozilla.org',
	'github.com'
);
for( $i = 0; $i < count($internet); $i++ ) {
	$internet[$i] = 'http://' . $internet[$i] . '/';
}
$getRandomInternetUrl = function() use($internet) {
	return $internet[ rand( 0, count($internet) - 1 ) ];
};

$local = array(
	'http://test-work.localhost/'
);
for( $i = 1; $i <= $count / 5; $i++ ) {
	$local[] = $local[0] . 'page' . $i . '.html';
}
$getRandomLocalUrl = function() use($local) {
	return $local[rand(0, count($local) - 1)];
};

$dateTimeInterval = array(
	'min' => \DateTime::createFromFormat($datetimeFormat, '2016-09-01 00:00:00')->getTimestamp(),
	'max' => \DateTime::createFromFormat($datetimeFormat, '2016-10-01 00:00:00')->getTimestamp()
);
$tmp = new \DateTime();
$tmp->setTimestamp($dateTimeInterval['min']);
$getRandomDateTime = function($asString = false) use($dateTimeInterval, $datetimeFormat) {
	$rand = rand($dateTimeInterval['min'], $dateTimeInterval['max']);
	$dateTime = new \DateTime();
	$dateTime->setTimestamp($rand);
	if ($asString) {
		return $dateTime->format($datetimeFormat);
	} else {
		return $dateTime;
	}
};

$intervalInterval = array(
	'min' => 60 * 2,
	'max' => 60 * 5
);
$getRandomInterval = function() use($intervalInterval, $datetimeFormat) {
	$rand = rand($intervalInterval['min'], $intervalInterval['max']);
	$di = new \DateInterval('PT' . $rand . 'S');
	return $di;
};

$statement = \App\Db::getInstance()->getStatement("
	INSERT INTO log (time, ip, source, destination)
	VALUES (:time, :ip, :source, :destination)
");
for( $i = 0; $i < count($ips); $i++ ) {
	$ip = $ips[$i];
	$source = $getRandomInternetUrl();
	$destination = $getRandomLocalUrl();
	$startTime = $getRandomDateTime();
	$statement->execute(array(
		':ip' => $ip,
		':time' => $startTime->format($datetimeFormat),
		':source' => $source,
		':destination' => $destination
	));
	$countRecords = rand(5, 15);
	$currentTime = $startTime;
	for( $j = 0; $j < $countRecords - 1; $j++ ) {
		$currentTime->add($getRandomInterval());
		$params = array(
			':ip' => $ip,
			':time' => $currentTime->format($datetimeFormat)
		);
		$params[':source'] = $destination;
		$destination = $getRandomLocalUrl();
		$params[':destination'] = $destination;
		$statement->execute($params);
	}
	$currentTime->add($getRandomInterval());
	$params = array(
		':ip' => $ip,
		':time' => $currentTime->format($datetimeFormat)
	);
	$params[':source'] = $destination;
	$destination = $getRandomInternetUrl();
	$params[':destination'] = $destination;
	$statement->execute($params);
}

$browsers = array(
	'Firefox',
	'Google-Chrome',
	'IE'
);
$getRandomBrowser = function() use($browsers) {
	return $browsers[rand(0, count($browsers) - 1)];
};

$os = array(
	'Windows',
	'Linux',
	'MacOS'
);
$getRandomOs = function() use($os) {
	return $os[rand(0, count($os) - 1)];
};

$statement = \App\Db::getInstance()->getStatement("
	INSERT INTO browsers (ip, name, os)
	VALUES (:ip, :name, :os)
");
for( $i = 0; $i < count($ips); $i++ ) {
	$ip = $ips[$i];
	$statement->execute(array(
		':ip' => $ip,
		':name' => $getRandomBrowser(),
		':os' => $getRandomOs()
	));
}
