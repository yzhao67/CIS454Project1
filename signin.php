<!DOCTYPE html>
<html>
<body>

<div>
<p>
  <a href="index.html">untitled</a>
  <button onclick="location.href = 'logout.php';" >Log Out</button>
</p>
</div>

<?php
   $input_usr = $_GET['UserName'];
   $input_pwd = $_GET['Password'];

   session_start();
   if($input_usr=="" and $input_pwd==("") and $_SESSION['UserName']!="" and $_SESSION['Password']!=""){
      $input_usr = $_SESSION['UserName'];
      $input_pwd = $_SESSION['Password'];
   }

   $conn = getDB();
   //$input_pwd = sha1($input_pwd);
   /* start make change for prepared statement */
   $sql = "SELECT ID, UserName, FirstName, LastName, Password, Address, Email
           FROM Users
           WHERE UserName= '$input_usr' and Password='$input_pwd'";
   if (!$result = $conn->query($sql)) {
       die('There was an error running the query [' . $conn->error . ']\n');
   }

   /* convert the select return result into array type */
   $return_arr = array();
   while($row = $result->fetch_assoc()){
       array_push($return_arr,$row);
   }

   /* convert the array type to json format and read out*/
   $json_str = json_encode($return_arr);
   $json_a = json_decode($json_str,true);
   $id = $json_a[0]['ID'];
   $name = $json_a[0]['UserName'];
   $fname = $json_a[0]['FirstName'];
   $lname = $json_a[0]['LastName'];
   $pwd = $json_a[0]['Password'];
   $address = $json_a[0]['Address'];
   $email = $json_a[0]['Email'];
   if($id!=""){
   	drawLayout($id,$name,$fname,$lname,$pwd,$email,$address);
   }else{
	echo "The account information your provide does not exist</br>";
	return;
   }
   /* end change for prepared statement */

   $conn->close();

function getDB() {
   $dbhost="localhost";
   $dbuser="root";
   $dbpass="";
   $dbname="users";


   // Create a DB connection
   $conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
   if ($conn->connect_error) {
         die("Connection failed: " . $conn->connect_error . "\n");
   }
return $conn;
}

function   drawLayout($id,$name,$fname,$lname,$pwd,$address,$email){
   if($id!=""){
   	  // session_start();
           $_SESSION['ID'] = $id;
           $_SESSION['UserName'] = $name;
	   $_SESSION['Password'] = $pwd;
   }else{
	echo "can not assign session";
   }
   if ($name !="admin") {
   	echo "<br><h3> $name's Profile</h3>";
	echo "<table>";
  echo "<tr>";
  echo "<td>ID</td>";
  	echo "<td>$id</td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td>First Name</td>";
  	echo "<td>$fname</td>";
	echo "</tr>";
	echo "<tr>";
  echo "<td>Last Name</td>";
  	echo "<td>$lname</td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td>Password</td>";
  	echo "<td>$pwd</td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td>Address</td>";
  	echo "<td>$address</td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td>Email</td>";
  	echo "<td>$email</td>";
	echo "</tr>";

	echo "</table>";

  //echo "<h3>My Favorite Items:<h3></br>";

  //echo "<h3>My Wish List:<h3></br>";
   }
   else {
        $conn = getDB();
   	$sql = "SELECT ID, UserName, FirstName, LastName, Password, Address, Email
           FROM Users";
   	if (!$result = $conn->query($sql)) {
       		die('There was an error running the query [' . $conn->error . ']\n');
   	}
   	$return_arr = array();
   	while($row = $result->fetch_assoc()){
       		array_push($return_arr,$row);
   	}
   	$json_str = json_encode($return_arr);
   	$json_aa = json_decode($json_str,true);
        $conn->close();
        $max = sizeof($json_aa);
        for($i=0; $i< $max;$i++){
	   //TODO: printout all the data for that users.
  	   $i_id = $json_aa[$i]['ID'];
  	   $i_name= $json_aa[$i]['UserName'];
  	   $i_fname= $json_aa[$i]['FirstName'];
  	   $i_lname= $json_aa[$i]['LastName'];
       $i_pwd = $json_aa[$i]['Password'];
  	   $i_address= $json_aa[$i]['Address'];
       $i_email= $json_aa[$i]['Email'];
   	   echo "<br><h4> $i_name's Profile</h4>";
  	   echo "First Name: $i_fname     ";
   	   echo "<br>Last Name: $i_lname     ";
   	   echo "<br>Password: $i_pwd    ";
   	   echo "<br>Address: $i_address";
   	   echo "<br>Email: $i_email";


	}
   }

}
?>
<!--
<div>
<p>
<button onclick="location.href = 'edit.php';" id="editBtn" >Edit</button>
</p>
</div>
-->
