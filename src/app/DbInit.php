<?php

namespace App;

class DbInit {
	
	/**
	 * Создание таблиц
	 * @return boolean
	 */
	public static function createTables() {
		$db = Db::getInstance();
		$queries = array();
		$queries['log'] = "
			CREATE TABLE log(
				date varchar(255),
				time varchar(255),
				ip varchar(255),
				source text,
				destination text
			)
		";
		$queries['browsers'] = "
			CREATE TABLE browsers(
				ip varchar(255),
				name text,
				os text
			)
		";
		$results = array();
		$results['log'] = $db->query($queries['log']);
		$results['browsers'] = $db->query($queries['browsers']);
		return ((boolean) ($results['log'] !== false && $results['browsers'] !== false));
	}
	
}
