<?php

use PHPUnit\Framework\Attributes\BeforeClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Depends;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;

class db_useTest extends TestCase {

	#[BeforeClass]
	public static function get_db_connection_info() : void {
		// Initialize everything to use the 'connection_db' function from the file connection.php.
		$_SERVER["DOCUMENT_ROOT"] = realpath(path: "../../");
		require $_SERVER["DOCUMENT_ROOT"] . "/php_db/connection.php";
		$GLOBALS["db_credentials"] = $db_credentials;
	}

	#[TestDox("Test the connection to the DB is OK.")]
	public function test_db_connection() : PDO {
		$pdo = connection_db();
		$this->assertTrue(true);
		return $pdo;
	}

	public static function table_provider() : array {
		$data_set = [
			["User", true, ["pseudo", "password"]],
			["Gbhdezl", false, []]
		];
		return array_combine(
			array_map(
				callback: function ($inputs) {
					if ($inputs[1]) {
						return "Table '" . $inputs[0] . "' does exist with columns: " . join(
							separator: ", ",
							array: $inputs[2]
						) . ".";
					} else {
						return "Table '" . $inputs[0] . "' doesn't exist.";
					}
				},
				array: $data_set
			),
			$data_set
		);
	}

	#[Depends("test_db_connection")]
	#[DataProvider("table_provider")]
	#[TestDox("Test whether the table exists or not.")]
	public function test_table_exist(string $table_name, bool $exist, array $columns_name, PDO $pdo) : void  {
		$pdo_statement = $pdo->query(query: "SHOW TABLES LIKE '" . $table_name . "';");
		$this->assertEquals(
			expected: $exist ? 1 : 0,
			actual: $pdo_statement->rowCount(),
			message: "The table '" . $table_name . "' " . ($exist ? "doesn't" : "does") . " exist."
		);

		if ($exist) {
			foreach ($columns_name as $column_name) {
				$pdo_statement = $pdo->query(query: "SHOW COLUMNS FROM User LIKE '" . $column_name . "';");
				$this->assertEquals(
					expected: 1,
					actual: $pdo_statement->rowCount(),
					message: "The column '" . $column_name . "' does not exist int the table '" . $table_name . "'."
				);
			}
		}
	}
}
