<?php

namespace App;

/**
 * Вспомогательные функции
 */
class Utils {
	
	/**
	 * @param string $str вермя в формате HH:MM:SS
	 * @return \DateInterval|null
	 */
	public static function parseInterval($str) {
		if (strlen($str) !== 8) {
			return null;
		}
		$parts = explode(':', $str);
		$h = is_numeric($parts[0]) ? (int) $parts[0] : null;
		$m = is_numeric($parts[1]) ? (int) $parts[1] : null;
		$s = is_numeric($parts[2]) ? (int) $parts[2] : null;
		if ($h === null || $m === null || $s === null ||
		    $h < 0 || $h > 23 ||
		    $m < 0 || $m > 59 ||
		    $s < 0 || $s > 59)
		{
			return null;
		}
		return new \DateInterval('PT' . $h . 'H' . $m . 'M' . $s . 'S');
	}
	
}
