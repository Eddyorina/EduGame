<?php

define("DB_HOST", "localhost");
define("DB_USER", "root");
define("DB_PASS", "");
define("DB_DATABASE", "edugame");

class Connection {

	public function getConnection() {
		return new mysqli(DB_HOST, DB_USER, DB_PASS, DB_DATABASE);
	}
}

?>