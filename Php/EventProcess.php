<?php
/*
@author psindhu@luc.edu

Functionalities : 
1. Each section is called, based on the 'type' of Ajax request
2. if 'type' = 'new' , insert events into database
3. if 'type' = 'changetitle' , change the title of the event
4. if 'type' = 'resetdate', change the timings of the event
5. if 'type' = 'remove', deleting the event
6. if 'type' = 'fetch', selecting the event
*/
include('dbconnect.php');
include("ManageEmail.php");
session_start();
$type = $_POST['type'];
try
    {
       
        if($type == 'new')
        {
           $userid = $_SESSION['user_id'];
            $startdate = $_POST['startdate'];
            $title = $_POST['title'];
            $startTime = $_POST['startTime'];
            $endTime = $_POST['endTime'];
            $sql = "INSERT INTO events(`UserId`, `Date`, `StartTime`, `EndTime`,`Details`)"
                    . " VALUES('$userid','$startdate','$startTime','$endTime','$title')";
            $insert = $pdo->query($sql);
            $lastid = $pdo->lastInsertId();
            echo json_encode(array('status'=>'success','eventid'=>$lastid));
            $subject = "New Event Added";
            $body = "Dear RiverPlaza Member, <br><br>An event is added to your calendar on ".explode("T", $startdate)[0].
                    "<br>Event Title - " .$title.
                    "<br>For further details visit our website.".
                    "<br>".
                    "<br>Regards,".
                    "<br>River Plaza Management.";
            $usersQuery = "SELECT Email, UserId FROM users WHERE Privilege = 'Resident'";
            $users = $pdo->query($usersQuery);
            foreach($users as $user){
                sendEmail($_SESSION["user_id"], $user['Email'], $subject, $body, $user['UserId'], $_SESSION["user_id"]);
            }
        }

        if($type == 'changetitle')
        {
            $eventid = $_POST['eventid'];
            $title = $_POST['title'];
            $sql = "UPDATE events SET Details='$title' where EventId='$eventid'";
            $update = $pdo->query($sql);
            if($update)
                echo json_encode(array('status'=>'success'));
            else
                echo json_encode(array('status'=>'failed'));
        }

        if($type == 'resetdate')
        {
            $title = $_POST['title'];
            $startdate = $_POST['start'];
            $startTime = $_POST['startTime'];
            $endTime = $_POST['endTime'];
            $eventid = $_POST['eventid'];
            $sql = "UPDATE events SET"
                    . " Details='$title',Date='$startdate',"
                    . " StartTime = '$startTime', EndTime = '$endTime'"
                    . " where EventId='$eventid'";
            $update = $pdo->query($sql);        
            if($update)
            {
                echo json_encode(array('status'=>'success'));
                $subject = "Event Updated";
                $body = "Dear RiverPlaza Member, <br><br>The Event ".$title." on ".explode("T", $startdate)[0]." is updated.".
                    "<br>Event Title - " .$title.
                    "<br>Event Start Time - " .$startTime.
                    "<br>Event End Time - " .$endTime.
                    "<br>Please find further details on our website.".
                    "<br>".
                    "<br>Regards,".
                    "<br>River Plaza Management.";
                $usersQuery = "SELECT Email, UserId FROM users WHERE Privilege = 'Resident'";
                $users = $pdo->query($usersQuery);
                foreach($users as $user){
                    sendEmail($_SESSION["user_id"], $user['Email'], $subject, $body, $user['UserId'], $_SESSION["user_id"]);
                }
            }
            else
                echo json_encode(array('status'=>'failed'));
            
        }

        if($type == 'remove')
        {
            $eventid = $_POST['eventid'];
            $sql = "DELETE FROM events where EventId='$eventid'";
            $delete = $pdo->query($sql);    
            if($delete)
                echo json_encode(array('status'=>'success'));
            else
                echo json_encode(array('status'=>'failed'));
        }

        if($type == 'fetch')
        {
            $events = array();
            $sql = "SELECT * FROM events";
            $query = $pdo->query($sql); 
            foreach($query as $fetchRow)
            {
                $e = array();
                $e['id'] = $fetchRow['EventId'];
                $e['title'] = $fetchRow['Details'];
                $e['start'] = $fetchRow['Date'].'T'.$fetchRow['StartTime'];
                $e['end'] = $fetchRow['Date'].'T'.$fetchRow['EndTime'];
                $allday = (($fetchRow['StartTime'] == "00:00:00") && ($fetchRow['EndTime'] == "00:00:00")) ? true : false;
                $e['allDay'] = $allday;
                array_push($events, $e);
            }
            echo json_encode($events);
        }
    }
    catch(PDOException $e)
    {
        die("Something happened:" . $e->getMessage());
    }
?>