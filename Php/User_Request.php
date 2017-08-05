<?php

// Common Code Starts
session_start();

if( ! isset($_SESSION["user_id"])) {
	header('Location: index.html');
    exit;
}

$userid = $_SESSION["user_id"];
$firstname = $_SESSION["first_name"];
$lastname = $_SESSION["last_name"];


include("dbconnect.php");



	$Request_var = $_POST["RequestType"];
	$Priority_var = $_POST["Priority"];
	$Phone_number = $_POST["ContactNumber"];
	$Description_var = $_POST["Description"];
	$currentdate = date("Y-m-d H:i:s");
	
	
	
	
try{	
$sql = "Insert into requests (RequestType, UserId, Priority, ContactNo, description, Date, Status)
values ('$Request_var',$userid, '$Priority_var', '$Phone_number', '$Description_var', '$currentdate', 'New')";
$pdo->exec($sql);
}
catch(PDOException $e)
{
	echo "error adding records" .$e;
}



        $URL="User_Request.html.php";
        echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';


?>



