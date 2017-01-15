<?php

namespace App;

/**
 * Основной класс для взаимодействия с клиентом
 */
class Main {
	
	public static function main() {
		header('Content-Type: application/json');
		try {
			$main = new Main();
			$resp = $main->getResponse();
			$data = array(
				'success' => true,
				'data' => $resp
			);
			echo json_encode($data);
		} catch (\Exception $e) {
			$error = array(
				'success' => false,
				'message' => $e->getMessage(),
				'file' => $e->getFile(),
				'line' => $e->getLine(),
				'stack_trace' => $e->getTraceAsString()
			);
			echo json_encode($error);
		}
	}
	
	public function getResponse() {
		$query = "
			SELECT
				log.date,
				log.time,
				log.ip,
				log.source,
				log.destination,
				browsers.name browser,
				browsers.os os
			FROM
				log
				INNER JOIN browsers ON
					browsers.ip = log.ip
		";
		$db = Db::getInstance();
		return $db->selectAll($query);
	}
	
}
