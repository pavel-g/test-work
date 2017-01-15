<?php

namespace App;

/**
 * Класс для получения конфигурации
 */
class Config {
	
	private static $cfg = null;
	
	public static function getCfg() {
		if (self::$cfg === null) {
			self::$cfg = require_once(__DIR__ . '/../config/config.php');
		}
		return self::$cfg;
	}
	
}
