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
	
	/**
	 * @param string $date дата записанная в формате YYYY-MM-DD
	 * @param string $time время записанное в формате HH:MM:SS
	 * @return \DateTime|null
	 */
	public static function parseDateTime($date, $time) {
		$res = \DateTime::createFromFormat('Y-m-d H:i:s', $date . ' 00:00:00');
		if ($res === false) return null;
		$interval = self::parseInterval($time);
		if ($interval === null) return null;
		$res->add($interval);
		return $res;
	}
	
	/**
	 * Проверка записи в строке целого числа
	 * @param string $str
	 * @return boolean
	 */
	public static function checkInteger($str) {
		$res = preg_match('/^\\d+$/', $str);
		return ((boolean) (is_numeric($res) && $res > 0));
	}
	
	/**
	 * Получение ip адреса для фильтра
	 * @param string $value
	 * @return string|null
	 */
	public static function parseIpFilter($value) {
		$minIp = 0;
		$maxIp = 255;
		if (gettype($value) !== 'string') return null;
		$parts = explode('.', $value);
		if (count($parts) >= 5) return null;
		for( $i = 0; $i < count($parts); $i++ ) {
			$part = $parts[$i];
			if (gettype($part) === 'string' && strlen($part) === 0 && ($i === 0 || $i === count($parts) - 1)) {
				continue;
			}
			if (!self::checkInteger($part)) return null;
			$num = (integer) $part;
			if ($num < $minIp || $num > $maxIp) return null;
		}
		return '%' . $value . '%';
	}
	
	/**
	 * Конвертация фильтров ExtJS в ассоциативный массив
	 * @param string $filters фильтры от extjs
	 * @return array
	 */
	public static function parseExtjsFilters($filters) {
		$data = json_decode($filters, true);
		if ($data === null) return array();
		$res = array();
		foreach( $data as $filter ) {
			$res[$filter['property']] = $filter['value'];
		}
		return $res;
	}
	
}
