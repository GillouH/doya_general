<?php
// Test if the form has been submitted.
$is_form_submitted = isset($_POST["pseudo"]) && isset($_POST["password"]);

// If the form has been submitted, we check if the user exists in the DB with the password.
if ($is_form_submitted) {
	// Read user inputs in the form.
	$pseudo = strip_tags($_POST["pseudo"]);
	$password = strip_tags($_POST["password"]);

	// Import the function to connect to the DB and use it.
	require $_SERVER["DOCUMENT_ROOT"] . "/asserts/php/db/connection.php";
	$pdo = connection_db();

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
    <?php include("asserts/php/header.php"); ?>
    <title>Doya_General</title>
</head>
<body>
    <!-- navbar  -->
    <nav>
        <div class="logo"><a href="#"><img src="assets/images/logo.svg" alt="Not found"></a></div>
        <div class="soc">
            <ul>
                <li><a href="#" class="bi-twitter"></a></li>
                <li><a href="#" class="bi-facebook"></a></li>
                <li><a href="#" class="bi-linkedin"></a></li>
            </ul>
        </div>
    </nav>
    <!-- content  -->

    <div id="welcome">
    <h1>Join<br>The Creative<br>Community</h1>
        <!-- <br> -->
            <p>To Access this website You Must Have an Account, <a href="#">Sign Up</a>

            </p>
        </div>


        <button id="showLoginFormButton"> Login </button>


        <div id="loginModal" class="modal">
            <div class="modal-content">
                <span class="close" id="closeModal"> <i class="bi-x"></i></span>
                <h2 style="text-align: center;margin-top: -20px;" >Login</h2><br>
                <form method="post" id="login">
                        <legend style="margin-top: -20px;">Guess a Username and Password !</legend>
                        <p>
                            <label for="user"><i class="bi-person"></i></label>
                            <input type="text" placeholder="Username" value="<?php echo $pseudo ? $pseudo : ""; ?>" name="pseudo" id="user" size="20" maxlength="10" required autofocus />
                        </p>
                        <p>
                            <label for="psw"><i class="bi-key"></i> </label>
                            <input type="password" placeholder="*******" value="<?php echo $pseudo ? $password : ""; ?>" name="password" id="psw" size="20" required />
                        </p>
                        <input type="submit" value="Test credential !" id="loginButton" style="margin-top: 30px;">

                </form>
            </div>
        </div>


    <!-- Blob  -->
        <div class="blob">

        </div>

    <!-- Blob -->


        <!-- JavaScript -->
        <script src="assets/js/main.js"></script>
		<?php include("asserts/php/footer.php"); ?>
</body>
</html>
