<?php

$server = "127.0.0.1";
$username = "root";
$password = "nilemonitor354";
$db = "iAdvisor";
$port = "3306";

$connection = mysqli_connect($server, $username, $password, $db, $port);

// Check connection
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

$query = "SELECT
    abbreviation, class_num, class_name, core, credits, class_id
FROM
    Course c
        JOIN
    school s ON c.school_id = s.school_id
ORDER BY class_num";

//This array will hold the names of each class
$classList = array();

$result = mysqli_query($connection, $query);
//Queries the database to get the individual parts of the class names and combine them
if ($result->num_rows > 0) {
    while($row = mysqli_fetch_assoc($result)) {
		array_push($classList, $row["abbreviation"] . (string)$row["class_num"] . ": " . $row["class_name"]
    . ": Credits " . $row["credits"]);
    }

} else {
    echo "0 results";
}
echo "<center><strong>New Users Please Fill Out This Form</strong></center><br>";


//Start of the form
echo "<form action='form_check.php' name='new_user_form' method='post'>";

//First Name of User
echo "<div>Enter Your First Name</div>";
echo "<input type = 'text' name = 'first_name'><br>";

//Last Name of User
echo "<div>Enter Your Last Name</div>";
echo "<input type = 'text' name = 'last_name'><br>";

//User UID Number
echo "<div>Enter Your UID</div>";
echo "<input type = 'text' name = 'uid'><br>";

//User Univertiy Emaile
echo "<div>Enter Your Univertiy Email (EX: jdoe@umd.edu)</div>";
echo "<input type = 'text' name = 'email'><br>";

echo "<br><div>What classes have you taken already?</div>";
//Adds the list of classes as checkboxes
$i = 0;
foreach ($classList as $value) {
	echo  "<input type='checkbox' name='classes[]' value ='". $value ."'> " . $value . "<br>";
	$i++;
}
echo "<br><input type='submit' value='submit'>";
echo "</form>";


?>