<?php

namespace App;

/**
 * Класс для доступа к базе данных
 */
class Db {
	
	/**
	 * @var App\Db экземпляр класса для соединения с базой данных
	 */
	private static $instance = null;
	
	/**
	 * Получение экземпляра класса
	 * @return App\Db
	 */
	public static function getInstance() {
		if (self::$instance === null) {
			self::$instance = new Db();
		}
		return self::$instance;
	}
	
	/**
	 * @var \PDO
	 */
	private $pdo = null;
	
	public function __construct() {
		$cfg = Config::getCfg();
		$dbname = $cfg['dbname'];
		$host = $cfg['dbhost'];
		$dbuser = $cfg['dbuser'];
		$dbpass = $cfg['dbpass'];
		$port = $cfg['dbport'];
		$this->pdo = new \PDO("pgsql:dbname=$dbname;host=$host;port=$port", $dbuser, $dbpass);
	}
	
	/**
	 * @return \PDO
	 */
	public function getPdo() {
		return $this->pdo;
	}
	
	/**
	 * @param string $query sql запрос
	 * @return \PDOStatement
	 */
	public function getStatement($query) {
		return $this->getPdo()->prepare($query);
	}
	
	/**
	 * @param string $query запрос
	 * @param array|null $params параметры
	 * @return \PDOStatement
	 */
	private function prepare($query, $params) {
		$statement = $this->getStatement($query);
		if (gettype($params) === 'array' && count($params) > 0) {
			$statement->execute($params);
		} else {
			$statement->execute();
		}
		return $statement;
	}
	
	/**
	 * Получение данных из запроса select
	 * @param string $query текст запроса
	 * @param array|null $params параметры к запросу
	 * @return array|null результат select-а
	 */
	public function select($query, $params = null) {
		$statement = $this->prepare($query, $params);
		$data = $statement->fetch(\PDO::FETCH_ASSOC);
		if ($data === false) {
			return null;
		} else if (gettype($data) === 'array' && count($data) > 0) {
			return $data;
		} else {
			return null;
		}
	}
	
	/**
	 * Получение всех данных из запроса select
	 * @param string $query текст запроса
	 * @param array|null $params параметры к запросу
	 * @return array|null результат select-а
	 */
	public function selectAll($query, $params = null) {
		$statement = $this->prepare($query, $params);
		$data = $statement->fetchAll(\PDO::FETCH_ASSOC);
		if ($data === false) {
			return null;
		} else if (gettype($data) === 'array' && count($data) > 0) {
			return $data;
		} else {
			return null;
		}
	}
	
	/**
	 * Выполнение запроса в базе
	 * @param string $query текст запроса
	 * @param array|null $params параметры к запросу
	 * @return \PDOStatement
	 */
	public function query($query, $params = null) {
		return $this->prepare($query, $params);
	}
	
}
