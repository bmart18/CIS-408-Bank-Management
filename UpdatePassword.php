<?php
include("config.php");
session_start();

$id = $_SESSION['id'];


if ( !isset($_POST['current-password'], $_POST['new-password'], $_POST['retype-new-password']) ) {
	// only if it cant get the data
  echo '<script type="text/javascript">alert("Please Fill in all Spots");</script>' ;
	echo '<script type="text/javascript">location.replace("homepage.php");</script>' ;
}else if($_POST['new-password'] != $_POST['retype-new-password']){
	echo '<script type="text/javascript">alert("Your new password does not match, please try again.");</script>' ;
	echo '<script type="text/javascript">location.replace("homepage.php");</script>' ;

}else{

			$sql="SELECT password FROM Logins WHERE id = $id";
			$result = $con->query($sql);
		  if (mysqli_num_rows($result) > 0) {

				$followingdata = $result -> fetch_assoc();
				$password = $followingdata['password'];




			$newpassword = $_POST['new-password'];
		  if ($_POST['current-password'] == $password) {

		    //update pass
				mysqli_query($con,"UPDATE Logins set password= '$newpassword' WHERE id='$id'");
				echo '<script type="text/javascript">alert("Password has successfully been updated!");</script>' ;
				echo '<script type="text/javascript">location.replace("homepage.php");</script>' ;
		  } else {

				echo '<script type="text/javascript">alert("The Password you have entered does not match your current password!");</script>' ;
				echo '<script type="text/javascript">location.replace("homepage.php");</script>' ;
		  }
		}
}

 ?>
