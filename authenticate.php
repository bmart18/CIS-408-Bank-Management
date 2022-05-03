<?php

include("config.php");

session_start();


// Now we check if the data from the login form was submitted, isset() will check if the data exists.
if ( !isset($_POST['username'], $_POST['password']) ) {
	// only if it cant get the data
	exit('Please fill both the username and password fields!');
}


// Prepare our SQL, preparing the SQL statement will prevent SQL injection.
if ($stmt = $con->prepare('SELECT id, password FROM Logins WHERE username = ?')) {

 $stmt->bind_param('s', $_POST['username']);
 $stmt->execute();
 // Store the result so we can check if the account exists in the database.
 $stmt->store_result();

 if ($stmt->num_rows > 0) {
 	$stmt->bind_result($id, $password);
 	$stmt->fetch();
}
}


 	if ($_POST['password'] === $password) {

 		session_regenerate_id();
 		$_SESSION['loggedin'] = TRUE;
 		$_SESSION['name'] = $_POST['username'];
 		$_SESSION['id'] = $id;
 		header('Location: homepage.php');
 	} else {
 		// Incorrect password
		echo '<script type="text/javascript">alert("invalid credentials");</script>' ;
		echo '<script type="text/javascript">location.replace("index.html");</script>' ;

}

 $stmt->close();

?>
