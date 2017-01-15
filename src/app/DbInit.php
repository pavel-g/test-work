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
				time timestamp with time zone,
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
	
	/**
	 * Удаление таблиц
	 * @return boolean
	 */
	public static function dropTables() {
		$db = Db::getInstance();
		$queries = array(
			'log' => "DROP TABLE log",
			'browsers' => "DROP TABLE browsers"
		);
		$results = array();
		$results['log'] = $db->query($queries['log']);
		$results['browsers'] = $db->query($queries['browsers']);
		return ((boolean) ($results['log'] !== false && $results['browsers'] !== false));
	}
	
	/**
	 * Очистка таблиц
	 * @return boolean
	 */
	public static function clearTables() {
		$db = Db::getInstance();
		$queries = array(
			'log' => "DELETE FROM log",
			'browsers' => "DELETE FROM browsers"
		);
		$results = array();
		$results['log'] = $db->query($queries['log']);
		$results['browsers'] = $db->query($queries['browsers']);
		return ((boolean) $results['log'] !== false && $results['browsers'] !== false);
	}
	
}
