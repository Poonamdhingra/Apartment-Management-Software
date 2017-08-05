<?php
/*
@author psindhu@luc.edu

Functionalities : 
1. Each section is called, based on the 'type' of Ajax request
2. if 'type' = 'updateStatus' , update the apartments status in the databse
3. if 'type' = 'create' , create an apartments into the database using prepare sql and bind values
4. if 'type' = 'fetch', selecting the residents information using join query
5. if 'type' = 'transaction', for php transaction and rollback - delete resident and the resident's history
6. if 'type' = 'mark', force completing the transactions for making the php trnsaction success
*/
require_once 'dbconnect.php';
$type = $_POST['type'];
try
    {
    if($type == 'updateStatus')
        {
            $apartment = $_POST['id'];
            $status = $_POST['status'];
            $sql = "UPDATE apartments SET Status='$status' where ApartmentNo='$apartment'";
            $update = $pdo->query($sql);
            if($update)
                echo json_encode(array('status'=>'success'));
            else
                echo json_encode(array('status'=>'failed'));
        }
        
    if($type == 'delete')
        {
            $apartment = $_POST['id'];
            $sql = "DELETE FROM apartments where ApartmentNo='$apartment'";
            $update = $pdo->query($sql);
            if($update)
                echo json_encode(array('status'=>'success'));
            else
                echo json_encode(array('status'=>'failed'));
        }
    if($type == 'create')
        {
            $sql = 'INSERT INTO apartments SET 
                    ApartmentNo =  :ApartmentNo,
                    SquareFeet = :SquareFeet,
                    LeaseAmount = :LeaseAmount,
                    MaintenaceFee = :MaintenaceFee,
                    Status = :Status';

            $insert = $pdo->prepare($sql);
            $insert->bindValue(':ApartmentNo', $_POST['apartment']);
            $insert->bindValue(':SquareFeet', $_POST['square']);
            $insert->bindValue(':LeaseAmount', $_POST['lease']);
            $insert->bindValue(':MaintenaceFee', $_POST['maintenance']);
            $insert->bindValue(':Status', 'Vacant');
            $insert->execute();
            
            echo json_encode(array('status'=>'success'));
            
        }
        
    if($type == 'fetch')
        {
        
            $info = array();
            $apartment = $_POST['id'];
            $sql = "SELECT Residents.MoveInDate, Residents.UserId, Residents.SSN,"
                    . " Users.FirstName, Users.LastName, Users.Email"
                    . " FROM Residents, Users WHERE Residents.ApartmentNo='$apartment'"
                    . " AND Users.UserId = Residents.UserId;";
            $result = $pdo->query($sql);
            foreach($result as $fetchRow)
            {
                $info['MoveInDate'] = $fetchRow['MoveInDate'];
                $info['UserId'] = $fetchRow['UserId'];
                $info['SSN'] = $fetchRow['SSN'];
                $info['FirstName'] = $fetchRow['FirstName'];
                $info['LastName'] = $fetchRow['LastName'];
                $info['Email'] = $fetchRow['Email'];
            }
         
            echo json_encode($info);
        }
    
    if($type =='transaction')
        {
            try
            {
                $pdo->beginTransaction();
                $resident = $_POST['id'];
                //Delete Request
                $delete_requests = "DELETE FROM requests WHERE UserId = '$resident'";
                $delete_requests_query = $pdo->query($delete_requests);
                
                //Delete Payments
                $delete_payments = "DELETE FROM transactions WHERE UserId = '$resident' AND status = 'Completed'";
                $delete_payments_query = $pdo->query($delete_payments);
                
                //Delete mails
                $delete_mails = "DELETE FROM mails WHERE UserIdReceiver = '$resident' OR UserIdSender = '$resident'";
                $delete_mails_query = $pdo->query($delete_mails);
             
                //Vacte the apartment
                $update_apartment = "UPDATE apartments SET Status='Vacant' WHERE "
                        . "ApartmentNo=(SELECT ApartmentNo FROM residents WHERE UserId = '$resident')";
                $update_apartment_query = $pdo->query($update_apartment);

                //Delete the residents
                $delete_residents = "DELETE FROM residents WHERE UserId = '$resident'";
                $delete_residents_query = $pdo->query($delete_residents);
                
                //Delete the user login
                $delete_users = "DELETE FROM users WHERE UserId = '$resident'";
                $delete_users_query = $pdo->query($delete_users);
                               
                $pdo->commit();
                echo json_encode(array('status'=>'success'));
            } 
            catch (Exception $ex) 
            {
                $pdo->rollback();
                echo json_encode(array('status'=>'failed', 'response' =>$ex->getMessage()));

            }
        }
    if($type =='mark')
        {
            $resident = $_POST['id'];
            $sql = "UPDATE transactions SET Status='Completed' where UserId = '$resident'";
            $update = $pdo->query($sql);
            if($update)
                echo json_encode(array('status'=>'success'));
            else
                echo json_encode(array('status'=>'failed'));
        }
    }
 catch(PDOException $e)
    {
        echo json_encode(array('status'=>'failed', 'response' =>$e->getMessage()));
    }
?>