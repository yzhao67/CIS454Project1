<!DOCTYPE html>
<html>
<head>
</head>

<body>
<?php
$input_usr = $_GET['UserName'];
$input_fname = $_GET['FirstName'];
$input_lname = $_GET['LastName'];
$input_pwd = $_GET['Password'];
$input_address = $_GET['Address'];
$input_email = $_GET['Email'];
//$input_info1 = $_GET['info1'];
//$input_info2 = $_GET['info2'];
//$input_info3 = $_GET['info3'];


$conn = new mysqli("localhost","root","","users","8080");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "INSERT INTO Users (UserName, FirstName, LastName, Password, Address, Email)
VALUES ('$input_usr', '$input_fname', '$input_lname', '$input_pwd', '$input_address', '$input_email')";

if ($conn->query($sql) === TRUE) {
    echo "New user created successfully";
    header("location: signin.html");

} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();

?>

</body>
</html>
