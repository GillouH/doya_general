<?php

// Read the file with all data to connect to the DB.
$db_credentials = json_decode(
	json: file_get_contents(filename: $_SERVER["DOCUMENT_ROOT"] . "/.db/db.json"),
	associative: true
);

function connection_db(): PDO {
	global $db_credentials;

	// Connection to the DB (PDO: Php Data Object -> an interface for accessing databases).
	return new PDO(
		dsn: "mysql:host=" . $db_credentials["db_host"] . ";port=" . $db_credentials["db_port"] . ";dbname=" . $db_credentials["db_name"],
		username: $db_credentials["username"],
		password: $db_credentials["password"]
	);
}
