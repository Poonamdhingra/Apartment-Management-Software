<?php
/*
@author psindhu@luc.edu

Functionalities : 
1. Using PDO, Calling Stored Procedure to delte mails every 30 days in trash Folder
2. Using PDO, Select the total count of Inbox new Mails
3. Using PDO, Select the mails of the corresponsing logged in user
*/

    opcache_reset();
    require_once 'dbconnect.php';
    session_start();
    $userId = $_SESSION["user_id"];
    try
    {
        $storedProcedureMails = "CALL DeleteMails();";
        $storedProcedureResult = $pdo->query($storedProcedureMails);
        
        $sql = "SELECT mails.*, users.Email, users.Privilege FROM"
                . " mails, users"
                . " where UserIdReceiver = '$userId' AND"
                . " ReadStatus IN ('New','Read') AND"
                . " users.UserId = mails.UserIdSender order by Date Desc";
        $query = $pdo->query($sql);
        $querySingle = $pdo->query($sql);


        $inboxNewCountQuery = "SELECT COUNT(*) as cnt from mails"
                . " WHERE UserIdReceiver = '$userId' AND ReadStatus = 'New'";
        $inboxNewCountResult = $pdo->query($inboxNewCountQuery);
        foreach($inboxNewCountResult as $result){
            $GLOBALS['unreadCount'] =  $result['cnt'];
        }

        $inboxCountQuery = "SELECT COUNT(*) as cnt from mails"
                . " WHERE UserIdReceiver = '$userId' AND"
                . " ReadStatus IN ('New','Read')";
        $inboxCountResult = $pdo->query($inboxCountQuery);
        foreach($inboxCountResult as $result){
            $GLOBALS['inboxCount'] =  $result['cnt'];
        }

        $deletStatusQuery = "SELECT mails.*, users.Email, users.Privilege FROM"
                . " mails, users"
                . " where UserIdReceiver = '$userId' AND"
                . " ReadStatus IN ('Deleted') AND"
                . " users.UserId = mails.UserIdSender"
                . " order by Date Desc";
        $deletStatusResult = $pdo->query($deletStatusQuery);

    }
    catch(PDOException $e)
    {
        die("Something happened:" . $e->getMessage());
    }
    
?>