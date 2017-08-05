
<?php
include("mysqli_dbconnect.php");

if($link === false)
{
	die("error : could not connect" .mysqli_connect_error());
}

    $UserId = $_SESSION["user_id"];
	$Amount = $_POST["Amount"];
	$Date = $_POST["Date"];
	$Memo = $_POST["Memo"];
	
	
	
	
$sql = "INSERT INTO transactions (UserId,Date, Memo, Amount, Status )
    VALUES ('$UserId','$Date', '$Memo', '$Amount', 'Pending' )";
    
	
	if(mysqli_query($link, $sql))
{
	echo '<script language="javascript">';
        echo 'alert("Payment Successfull"); location.href="RES_payments_View.php"';
        echo '</script>';
		
}


else
{
	echo "error adding records". mysqli_error($link);
}


  
 

mysqli_close($link);
	
?>