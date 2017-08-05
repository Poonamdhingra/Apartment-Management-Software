<?php


include("dbconnect.php");


	$FirstName = $_POST["Firstname"];
	$LastName = $_POST["Lastname"];
	$Email = $_POST["email"];
	$Password = $_POST["password"];
	$CPassword = $_POST["cpassword"];
	$userEnteredPwdHash = password_hash($Password,PASSWORD_DEFAULT);
	
	
	
	if(($_POST["password"])!=($_POST["cpassword"]))
	{
    echo"Oops! Password did not match! Try again.";
	exit();
    }
	

	
try{
$sql = "Insert into users (FirstName, LastName, Email, Password, Privilege)
values ('$FirstName', '$LastName', '$Email', '$userEnteredPwdHash', 'Resident')";
$pdo->exec($sql);
}
catch(PDOException $e)
{
	echo "error adding records" .$e;
}



        $URL="SignIn.html";
        echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';


?>




