<?php

/* 
@author psindhu@luc.edu

 */
session_start();
$userId = $_SESSION["user_id"];
require_once 'dbconnect.php';
$type = $_POST['type'];

try
    {
        if($type == 'Delete'){
            $id = $_POST['id'];
            $sql = "Update mails SET ReadStatus='Deleted' where MailId='$id'";
            $query = $pdo->query($sql);
            echo json_encode(array('status'=>'success'));
        }

        if($type == 'count'){
            $value = array();
            $inboxCountQuery = "SELECT COUNT(*) as cnt from mails WHERE UserIdReceiver = '$userId' AND ReadStatus = 'New'";
            $inboxCountResult = $pdo->query($inboxCountQuery);
            foreach($inboxCountResult as $result){
                $value = $result['cnt'];
            }

           echo json_encode($value);

        }

        if($type == 'countInbox'){
            $value = array();
            $inboxCountQuery = "SELECT COUNT(*) as cnt from mails WHERE UserIdReceiver = '$userId' AND ReadStatus IN ('New', 'Read')";
            $inboxCountResult = $pdo->query($inboxCountQuery);
            foreach($inboxCountResult as $result){
                $value = $result['cnt'];
            }

           echo json_encode($value);

        }

        if($type == 'updateInbox'){
            $id = $_POST['id'];
            $inboxUpdateQuery = "UPDATE mails SET ReadStatus = 'Read' WHERE MailId ='$id'";
            $inboxUpdateResult = $pdo->query($inboxUpdateQuery);

            echo json_encode(array('status'=>'success'));

        }
    }
    catch(PDOException $e)
    {
        die("Something happened:" . $e->getMessage());
    }

?>