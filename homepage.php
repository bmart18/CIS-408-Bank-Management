<?php
//include the database connection info
include("config.php");

//start session
session_start();
// If the user is not logged in redirect to the login page
if (!isset($_SESSION['loggedin'])) {
	header('Location: index.html');
	exit;
}

global $savingsbalance;
global $checkingsbalance;
global $firstname;
global $lastname;
global $birthdate;
global $gender;
global $address;
global $mobilenumber;
global $occupation;

$id = $_SESSION['id'];



if ( mysqli_connect_errno() ) {
	// If there is an error with the connection, stop the script and display the error.
	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}


$sql = "SELECT savingsbalance, checkingbalance FROM AccountTable WHERE USERID = $id";
$result = $con->query($sql);
$followingdata = $result -> fetch_assoc();
	if ($result->num_rows > 0) {
		$savingsbalance = $followingdata["savingsbalance"] ;
		$checkingbalance = $followingdata["checkingbalance"] ;
		$_SESSION['USERsavingsbalance'] = $savingsbalance;
		$_SESSION['USERcheckingsbalance'] = $checkingbalance;
	}

	$sql = "SELECT FNAME, LNAME, BDATE, GENDER, ADDRESS,  MOBILENUMBER, OCCUPATION FROM ProfileTable WHERE USERID = $id";
	$result = $con->query($sql);
	$followingdata = $result -> fetch_assoc();
		if ($result->num_rows > 0) {
			$firstname = $followingdata["FNAME"] ;
			$lastname = $followingdata["LNAME"] ;
			$birthdate = $followingdata["BDATE"] ;
			$gender = $followingdata["GENDER"] ;
			$address = $followingdata["ADDRESS"] ;
			$mobilenumber = $followingdata["MOBILENUMBER"] ;
			$occupation = $followingdata["OCCUPATION"] ;

		}

$GETTransaction = "SELECT DateofTransaction, TypeofAccount, SenttoUser, TransactionAmount, CurrentBalance FROM TransactionHistory WHERE USERID = $id";
$TransactionTable = array();
$response = mysqli_query($con, $GETTransaction);
while($row = mysqli_fetch_array($response)){
	$TransactionTable[] = $row;
	//print_r( $row);
}





?>
<!doctype html>
<html>

<head>

    <title>CIS434 Bank</title>
    <link rel="stylesheet" href="assets/css/main.css">
    <script src="assets/js/main.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Secular+One&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Oswald&display=swap" rel="stylesheet">
</head>

<body>
    <div class="container">
        <div class="header-container">

            <h1 class="title">Welcome to CIS Banking!</h1>

            <a class="logout" href="logout.php">Logout</a>

            <div class="options">
                <div class="profile">
                    <a href="#" onclick="toggle_main('profile-container')">Profile</a>
                </div>
                <div class="transaction">
                    <a href="#" onclick="toggle_main('transaction-history-container')">Transactions History</a>
                </div>
                <div class="transfer">
                    <a href="#" onclick="toggle_main('transfer-container')">Transfer</a>
                </div>
                <div class="manageStaff">
                    <a href="#" onclick="toggle_main('Manage-staff-container')">Manage Staff</a>
                </div>
            </div>
        </div>

        <div class="transfer-container">

            <h1 class="transfer-label">Transfer</h1>

            <form class="transfer-form" action="TransferFunds.php" method="POST">
                <div class="transfer-inputs">
                    <label for="transfer-id">Enter User:</label>
                    <div><input type="text" id="transfer-id" name="transfer-id" placeholder="ex. 1234-5678-90"></div>
                    <label for="transfer-amount">Amount:</label>
                    <div><input type="text" id="transfer-amount" name="transfer-amount" placeholder="Enter amount">
                    </div>
                </div>
                <button class="transfer-submit" type="submit">Submit Transfer</button>
            </form>

        </div>

        <div class="transaction-history-container">
            <h1 class="Transaction-label">Transaction History</h1>
            <div id="transaction-table"></div>
            <script >

						var customers = JSON.parse('<?php echo json_encode($TransactionTable)?>');


						//Create a HTML Table element.
						var table = document.createElement("TABLE");
						table.border = "1";

						//Get the count of columns.
						var columnCount = customers[0][1].length/2;

						//Add the header row.
						var row = table.insertRow(-1);
						    var headerCell = document.createElement("TH");
						    headerCell.innerHTML = "Date";
						    row.appendChild(headerCell);
								var headerCell = document.createElement("TH");
								headerCell.innerHTML = "Account";
						    row.appendChild(headerCell);
								var headerCell = document.createElement("TH");
								headerCell.innerHTML = "Sent/Accepted From";
						    row.appendChild(headerCell);
								var headerCell = document.createElement("TH");
								headerCell.innerHTML = "Amount";
						    row.appendChild(headerCell);
								var headerCell = document.createElement("TH");
								headerCell.innerHTML = "CurrentBalance";
						    row.appendChild(headerCell);

						//Add the data rows.
						for (var i = 0; i < customers.length; i++) {
						    row = table.insertRow(-1);
						    for (var j = 0; j < columnCount; j++) {
						        var cell = row.insertCell(-1);
						        cell.innerHTML = customers[i][j];
						    }
						}

						var dvTable = document.getElementById("transaction-table");
						dvTable.innerHTML = "";
						dvTable.appendChild(table);

						</script>
        </div>

        <div class="profile-container">

            <h1 class="profile-label">Profile</h1>

            <div class="profile-content">
                <div class="profile-description">
                    <label>First name: </label>
                    <label> <?php echo $firstname; ?></label>
                    <label>Last name: </label>
                    <label> <?php echo $lastname; ?></label>
                    <label>User ID: </label>
                    <label> <?php echo $id; ?></label>
                    <label>Date of birth: </label>
                    <label> <?php echo $birthdate; ?></label>
                    <label>Gender: </label>
                    <label> <?php echo $gender; ?></label>
                    <label>Address: </label>
                    <label> <?php echo $address; ?></label>
                    <label>Mobile number: </label>
                    <label> <?php echo $mobilenumber; ?></label>
                    <label>Occupation: </label>
                    <label> <?php echo $occupation; ?></label>
                </div>
                <div class="profile-actions">
                    <div class="profile-update">
                        <br><button class="profile-update" onclick="toggle_main('update-profile-container')">Update
                            Profile</button>
                    </div>

                    <div class="profile-change-password">
                        <button class="profile-change-password"
                            onclick="toggle_main('change-password-container')">Change
                            Password</button>
                    </div>
                </div>
            </div>

        </div>

        <div class="update-profile-container">
            <h1 class="profile-label">Update Profile</h1>

            <form class="update-profile-form" action="UpdateProfile.php" method="POST">
                <div class="update-profile-inputs">
                    <label>First name: </label>
                    <label> <?php echo $firstname; ?></label>
                    <label>Last name: </label>
                    <label> <?php echo $lastname; ?></label>
                    <label>User ID: </label>
                    <label> <?php echo $id; ?></label>
                    <label>Date of birth: </label>
                    <label> <?php echo $birthdate; ?></label>
                    <label>Gender: </label>
                    <label> <?php echo $gender; ?></label>
                    <label>Address: </label>
                    <div><input type="text" id="new-address" name="new-address" value="<?php echo $address; ?>" /></div>
                    <label>Mobile number: </label>
                    <div><input type="text" id="new-number" name="new-number" value="<?php echo $mobilenumber; ?>" />
                    </div>

                    <label>Occupation: </label>
                    <div><input type="text" id="new-occupation" name="new-occupation"
                            value="<?php echo $occupation; ?>" /></div>

                </div>

                <div>
                    <br><button class="save-profile-update" type="submit">Save Changes</button>
                </div>
            </form>
        </div>

        <div class="change-password-container">

            <h1 class="change-password-label">
                Change Password
            </h1>

            <form class="change-password-form" action="UpdatePassword.php" method="POST">
                <div class="change-password-inputs">
                    <label for="current-password">Current Password:</label>
                    <div><input type="password" id="current-password" name="current-password"></div>
                    <label for="new-password">New Password:</label>
                    <div><input type="password" id="new-password" name="new-password"></div>
                    <label for="retype-new-password">Re-type New Password:</label>
                    <div><input type="password" id="retype-new-password" name="retype-new-password"></div>
                </div>
                <div>
                    <br><button class="change-password-submit" type="submit">Submit</button>
                </div>
            </form>
        </div>

        <div class="aside-container">
            <article>
                <h1>Current Balance</h1>
                <div class="accounts">
                    <div class="accounts-balance">
                        Checking: <?php echo $checkingbalance; ?>
                    </div>

                    <div class="savings-balance">
                        Savings: <?php echo $savingsbalance; ?>
                    </div>
                </div>
            </article>
        </div>

        <div class="Manage-staff-container">

            <h1 class="Manage-staff-label">Manage Staff</h1>

            <div class="row">
                <div class="column">
                    <div class="Manage-staff-card">
                        <div class="Manage-staff-table">
                            <h2>Abdul Mohamed</h2>
                            <p class="Manage-staff-title">Branch Manager</p>
                            <p>User ID: 2677918</p>
                            <p>Address: 3321 Castle, SPrig, TX</p>
                            <p>Mobile Number: 216-434-1234</p>
                            <p><button class="Manage-staff-button">Contact</button></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="column">
                    <div class="Manage-staff-card">
                        <div class="Manage-staff-table">
                            <h2>Dan Manolache</h2>
                            <p class="Manage-staff-title">Accountant</p>
                            <p>User ID: 2689960</p>
                            <p>Address: 5631 Rice, Houston, TX</p>
                            <p>Mobile Number: 216-123-4567</p>
                            <p><button class="Manage-staff-button">Contact</button></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="column">
                    <div class="Manage-staff-card">
                        <div class="Manage-staff-table">
                            <h2>Bradley Martin</h2>
                            <p class="Manage-staff-title">Financial Analyst</p>
                            <p>User ID: 2714857</p>
                            <p>Address: 100 Alfred Lane, Cleveland, Oh</p>
                            <p>Mobile Number: 216-555-6987</p>
                            <p><button class="Manage-staff-button">Contact</button></p>
                        </div>
                    </div>
                </div>
            </div>
            <button class="add-staff-button" onclick="toggle_main('add-staff-container')">Add Staff</button>
        </div>

        <div class="add-staff-container">
            <h1 class="add-staff-label">Add Staff</h1>
            <form class="add-staff-form" action="AddStaff.php" method="POST">
                <div class="add-staff-inputs">
                    <label for="add-staff-first-name">First name:</label>
                    <div><input type="text" id="first-name" name="first-name" /></div>
                    <label for="add-staff-last-name">Last name:</label>
                    <div><input type="text" id="last-name" name="last-name" /></div>
                    <label for="add-staff-userID">User ID:</label>
                    <div><input type="text" id="UserID" name="userID" /></div>
                    <label for="add-staff-dob">Date of Brith:</label>
                    <div><input type="date" id="date-of-Birth" name="date-of-Birth" /></div>
                    <label for="add-staff-gender">Gender:</label>
                    <div><input type="text" id="gender" name="gender" /></div>
                    <label for="add-staff-address">Address:</label>
                    <div><input type="text" id="address" name="address" /></div>
                    <label for="add-staff-mobile">Mobile Number:</label>
                    <div><input type="text" id="mobile-number" name="mobile-number" /></div>
                    <label for="add-staff-occupation">Occupation:</label>
                    <div><input type="text" id="occupation" name="occupation" /></div>
                </div>
                <div>
                    <br><button class="add-staff-submit">Submit</button>
                </div>
            </form>
        </div>

        <div class="footer-container">
            <footer class="wrapper">
                <h3>Something Wrong? Contact us at 1-800-CIS-Bank</h3>
            </footer>
        </div>

    </div>

</body>

</html>
