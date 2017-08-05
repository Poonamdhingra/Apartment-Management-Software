<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Checking Password with Bcrypt</title>
  </head>
  <body>
<?php
include("dbconnect.php");

$message = '';
$Email = $_POST['Email'];
$Password = trim($_POST['password']);
       
try
{
  $sql = "SELECT UserId, FirstName, LastName, Email, Password, Privilege  FROM users WHERE email = '$Email' limit 1";
  $results = $pdo->query($sql);   
  foreach ($results as $result) {
      $hash = trim($result['Password']);
	  $UserId = trim($result['UserId']);
	  $FirstName = trim($result['FirstName']);
	  $LastName = trim($result['LastName']);
	  $userEmail = trim($result['Email']);
	  $Privilege = trim($result['Privilege']);
	  
  }
}
catch (PDOException $e)
{
  $error = 'Database error!';
  echo "Unable to connect";
  //include 'error.html.php';
  exit();
}
	
if (password_verify($Password,$hash)){
	session_start();
    $message = "Welcome !!!! You have successfully logged in to our website.";
	$_SESSION["user_id"] = $UserId;
	$_SESSION["first_name"] = $FirstName;
	$_SESSION["last_name"] = $LastName;
	$_SESSION["email"] = $userEmail;
        $_SESSION["Privilege"] = $Privilege;
	
if ($Privilege == "Manager")
{
	header('Location: Admin_Dash.php');
    exit;
}
else
{
	header('Location: Resident_Dashboard1.html.php');
    exit;
}
	
	
	
}
else {
    $message = "Sorry!!! Not logged in. Please try again";
}

?>
      
<p><?php echo $message ?></p>
<!--<a href="index.php">Go back to home page</a>-->
</body>
</html>
