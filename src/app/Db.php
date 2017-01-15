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
		// Настройки соединения с базой:
		$dbname = 'test_work';
		$host = 'localhost';
		$dbuser = 'test_work';
		$dbpass = '123456';
		$port = '5433';
		// TODO: 2017-01-14 Вынести настройки в конфигурационный файл
		$this->pdo = new \PDO("pgsql:dbname=$dbname;host=$host;port=$port", $dbuser, $dbpass);
	}
	
	/**
	 * @return \PDO
	 */
	public function getPdo() {
		return $this->pdo;
	}
	
	/**
	 * @param string $query запрос
	 * @param array|null $params параметры
	 * @return type description
	 */
	private function prepare($query, $params) {
		$pdo = $this->getPdo();
		$statement = $pdo->prepare($query);
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
	
	public function query($query, $params = null) {
		$statement = $this->prepare($query, $params);
	}
	
}
