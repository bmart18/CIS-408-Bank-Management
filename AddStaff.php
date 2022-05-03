<?php

include("config.php");

session_start();

$id = $_SESSION['id'];
$firstname = $_POST['first-name'] ;
$lastname = $_POST['last-name'];
$userid = $_POST['userID'];
$birthdate = $_POST["date-of-Birth"] ;
$gender = $_POST["gender"] ;
$address = $_POST["address"] ;
$mobilenumber = $_POST["mobile-number"] ;
$occupation = $_POST["occupation"] ;

$SQLcheck = "SELECT * FROM ProfileTable WHERE USERID='$userid'";
$result = $con->query($SQLcheck);


if ($result == FALSE) {

	echo '<script type="text/javascript">alert("Staff Already Exists.");</script>' ;
	echo '<script type="text/javascript">location.replace("homepage.php");</script>' ;

} else {
    $SQLinsertprofile = "INSERT INTO ProfileTable VALUES ('$firstname','$lastname','$userid','$birthdate','$gender','$address','$mobilenumber','$occupation')";
    $con->query($SQLinsertprofile);

		$Login = $firstname . $lastname;
		$SQLinsertlogin = "INSERT INTO Logins VALUES ('$Login','$Login','$userid')";
		$con->query($SQLinsertlogin);

		echo '<script type="text/javascript">alert("Staff Successfully Added. The Users Username AND Password will be their First and Last name with no spaces");</script>' ;
		echo '<script type="text/javascript">location.replace("homepage.php");</script>' ;

    }
?>
