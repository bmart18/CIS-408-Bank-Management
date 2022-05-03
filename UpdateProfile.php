<?php

include("config.php");

session_start();

$id = $_SESSION['id'];
$newAddress = $_POST['new-address'];
$newNumber = $_POST['new-number'];
$newOccupation = $_POST['new-occupation'];

if(count($_POST)>0) {
    $result = mysqli_query($con,"SELECT * from ProfileTable WHERE USERID='" . $id . "'");

    $row=mysqli_fetch_array($result);


    mysqli_query($con,"UPDATE ProfileTable set ADDRESS='$newAddress' WHERE USERID='$id'");
    mysqli_query($con,"UPDATE ProfileTable set MOBILENUMBER='$newNumber' WHERE USERID='$id'");
    mysqli_query($con,"UPDATE ProfileTable set OCCUPATION='$newOccupation' WHERE USERID='$id'");

		echo '<script type="text/javascript">alert("Profile Updated Successfully!");</script>' ;
		echo '<script type="text/javascript">location.replace("homepage.php");</script>' ;

    }
