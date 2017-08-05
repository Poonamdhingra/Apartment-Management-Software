<?php
include('dbconnect.php');
$type = $_POST['type'];
try
    {
    if($type == 'updateStatus')
        {
            $TransactionID = $_POST['id'];
            $status = $_POST['status'];
            $sql = "UPDATE transactions SET Status='$status' where TransactionID='$TransactionID'";
            $update = $pdo->query($sql);
            if($update)
                echo json_encode(array('status'=>'success'));
            else
                echo json_encode(array('status'=>'failed'));
        }
        
    
    } 
catch(PDOException $e)
    {
        die("Something happened:" . $e->getMessage());
    }
?>