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
				data.ip ip,
				data.source[1] source,
				data.destination[1] destination,
				data.count \"count\",
				data.browser browser,
				data.os os
			FROM
				(
					SELECT
						log.ip,
						array_agg(log.source ORDER BY log.time ASC) source,
						array_agg(log.destination ORDER BY log.time DESC) destination,
						count(DISTINCT log.destination)-1 \"count\",
						browsers.name browser,
						browsers.os os
					FROM
						log
						INNER JOIN browsers ON
							browsers.ip = log.ip
					GROUP BY
						log.ip,
						browser,
						os
				) data
		";
		$db = Db::getInstance();
		return $db->selectAll($query);
	}
	
}
