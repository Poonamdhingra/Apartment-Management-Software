
<?php
session_start();
 

 
$_SESSION["user_id"] = $UserId;
	$_SESSION["first_name"] = $FirstName;
	$_SESSION["last_name"] = $LastName;
	$_SESSION["email"] = $userEmail;

include("mysqli_dbconnect.php");

if($link === false)
{
	die("error : could not connect" .mysqli_connect_error());
}

	$SSN = $_POST["SSN"];
	$DateOfBirth = $_POST["DateOfBirth"];
	$PreviousAddress = $_POST["PreviousAddress"];
	$Pets = $_POST["Pets"];
	$MobileNo = $_POST["MobileNo"];
	$SpouseFName = $_POST["Spouse_Firstname"];
	$SpouseLName = $_POST["Spouse_Lastname"];
	$SpouseSSN = $_POST["SpouseSSN"];
	$SDateOfBirth = $_POST["SDateOfBirth"];
	$DateOfMovein = $_POST["Date_of_movein"];
	$AptNo = $_POST["AptNo"];
	
$sql = "Update residents 
 set UserId = '$UserId' , DateOfBirth = '$DateOfBirth', PreviousAddress = '$PreviousAddress', NumPets = '$Pets', SSN = '$SSN', 
 MoveInDate = '$DateOfMovein', MobileNumber ='$MobileNo', SpouseFirstName = '$SpouseFName', SpouseLastName = '$SpouseLName', SpouseDateOfBirth = '$SDateOfBirth', SpouseSSN = '$SpouseSSN', ApartmentNo='$AptNo'";
    
	
	if(mysqli_query($link, $sql))
{
	echo '<script language="javascript">';
        echo 'alert("Records Updated Successfully"); location.href="RES_View_PersonalDetails_Second.php"';
        echo '</script>';
}
else
{
	echo "error adding records". mysqli_error($link);
}

mysqli_close($link);
	
?>
