<?php

include("config.php");

session_start();
//make sure they have the mopney in their acc
if($_POST['transfer-amount'] > $_SESSION['USERcheckingsbalance']){

//if not send them right back to the transfer screen
  echo '<script type="text/javascript">alert("You do not have the funds to send to that user");</script>' ;
  echo '<script type="text/javascript">location.replace("homepage.php");</script>' ;


}else{



  //pull the variables and put them into local for the sql query
  $transferamount = $_POST['transfer-amount'];
  $transferid = $_POST['transfer-id'];
  $id = $_SESSION['id'];


  if ( mysqli_connect_errno() ) {
  	// If there is an error with the connection, stop the script and display the error.
  	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
  }
  //add the amount transfered to the selected user but before we do that we need to know the other persons data
  $sqlgetseconduseramount = "SELECT checkingsbalance FROM AccountTable WHERE USERID = $transferid";

  $result = $con->query($sqlgetseconduseramount);

  //if the user exists, get their new amount. if not tell the person they messed up and ship them back
		if (mysqli_num_rows($result) > 0) {
      	$followingdata = $result -> fetch_assoc();
        $seconduseramount = $followingdata['checkingsbalance'] + $transferamount;
        $date = date("Y-m-d");
        $name = 'Checkings';
          //subtract the amount transfering from the current user
          $newbalancecurrentuser = ($_SESSION['USERcheckingsbalance'] - $_POST['transfer-amount']);
          $sqlsubtractuser = "UPDATE AccountTable SET checkingsbalance = $newbalancecurrentuser  WHERE USERID = $id";
          $con->query($sqlsubtractuser);

          $subtractedamount = '-$' + strval($transferamount);
          $sqlsubtractusertransaction = "INSERT INTO TransactionHistory VALUES('$date', '$name', '$transferid', '-$$subtractedamount', '$newbalancecurrentuser', '$id')";
          $con->query($sqlsubtractusertransaction);

          //now update database for the user that got sent money AND GIVE A TRANSACTIOn REPORT FOR THAT USER
          $sqladduser = "UPDATE AccountTable SET checkingsbalance = $seconduseramount WHERE USERID = $transferid";
          $con->query($sqladduser);

          $addedamount = '+$' + strval($transferamount);
          //$sqladdusertransaction = "INSERT INTO TransactionHistory VALUES($date, $name, $id, $addedamount, $seconduseramount, $transferid)";
          $sqladdusertransaction = "INSERT INTO TransactionHistory VALUES('$date', '$name', '$id', '+$$addedamount', '$seconduseramount', '$transferid')";
          $result = $con->query($sqladdusertransaction);
          header('Location: homepage.php');



        }
    else{
      //incase the user theyre trying to send it to does not exist
      echo '<script type="text/javascript">alert("That user does not exist");</script>' ;
      echo '<script type="text/javascript">location.replace("homepage.php");</script>' ;

    }

}
$con->close();
 ?>
