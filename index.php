<?php
// Test if the form has been submitted.
$is_form_submitted = isset($_POST["pseudo"]) && isset($_POST["password"]);

// If the form has been submitted, we check if the user exists in the DB with the password.
if ($is_form_submitted) {
	// Read user inputs in the form.
	$pseudo = strip_tags($_POST["pseudo"]);
	$password = strip_tags($_POST["password"]);

	// Read the file with all data to connect to the DB.
	$db_credentials = json_decode(
		json: file_get_contents(filename: ".db/db.json"),
		associative: true
	);

	// Connection to the DB (PDO: Php Data Object -> an interface for accessing databases).
	$pdo = new PDO(
		dsn: "mysql:host=" . $db_credentials["db_host"] . ";port=" . $db_credentials["db_port"] . ";dbname=" . $db_credentials["db_name"],
		username: $db_credentials["username"],
		password: $db_credentials["password"]
	);

	// Prepares and executes an SQL statement.
	$pdo_statement = $pdo->query(query: "SELECT * FROM User WHERE BINARY pseudo='" . $pseudo . "' AND password=PASSWORD('" . $password . "');");

	// Test the number of result from the SQL statement and create the result sentence to display.
	$result_sentence = "The user " . $pseudo . " " . ($pdo_statement->rowCount() > 0 ? "does" : "doesn't") . " exist with the password " . $password . " !";
} else {
	// Default values.
	$pseudo = "";
	$password = "";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title>Doya General</title>
</head>

<body>
	<?php
	if ($is_form_submitted) {
	?>
		<h1><?php echo $result_sentence; ?></h1>
	<?php
	}
	?>
	<form action="" method="post">
		<fieldset>
			<legend>Guess a Username and Password !</legend>
			<p>
				<label for="user">Username: </label>
				<input type="text" value="<?php echo $pseudo ? $pseudo : ""; ?>" name="pseudo" id="user" size="20" maxlength="10" required autofocus />
			</p>
			<p>
				<label for="psw">Password: </label>
				<input type="password" value="<?php echo $pseudo ? $password : ""; ?>" name="password" id="psw" size="20" required />
			</p>
			<input type="submit" value="Test credential !">
		</fieldset>
	</form>
</body>

</html>
