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

// Common Code End







$id = $_GET['RequestId'];

try
			{
								
				
				$sql = "DELETE FROM requests WHERE RequestId = $id";
				$result = $pdo->query($sql);
				
				
				
			}
			
		catch (PDOException $e)
			{
				$error = 'Error deleting data: ' . $e->getMessage();
				exit();
			}

$URL="Admin_Request.html.php";
echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';



?>