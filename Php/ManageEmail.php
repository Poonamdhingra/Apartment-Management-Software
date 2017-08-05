<?php
/*
@author psindhu@luc.edu

Functionalities : 
1. Sending mails to '$toEmail' when this method is called.
2. Saving mails to database
3. Formating mails, as they can see email on their inboxes with line breaks and indendation

Built on PHP PEAR Mail
*/
require_once "Mail.php";

function sendEmail($fromEmail, $toEmail, $subject, $body, $receiver, $sender)
{    
    $headers = array(
        'From' => $fromEmail,
        'To' => $toEmail,
        'Subject' => $subject
    );
    
    $smtp = Mail::factory('smtp', array(
            'host' => 'ssl://smtp.gmail.com',
            'port' => '465',
            'auth' => true,
            'username' => 'mangementrp@gmail.com',
            'password' => 'test123456'
    ));
    $bodyModified  = str_replace("<br>", "\n", $body);
    $mail = $smtp->send($toEmail, $headers, $bodyModified);  
    
    if (PEAR::isError($mail)) 
    {
        echo('<p>' . $mail->getMessage() . '</p>');
    } 
    else 
    {
        storeEmail($receiver, $sender, $subject, $body);
    }
}

function storeEmail($receiver, $sender, $subject, $content){
    include('dbconnect.php');
    $sql = "INSERT INTO mails(`UserIdReceiver`, `UserIdSender`, `Date`, `Subject`,`Content`,`ReadStatus`) VALUES('$receiver','$sender',NOW(),'$subject','$content', 'New')";
    $query = $pdo->query($sql);
}

?>