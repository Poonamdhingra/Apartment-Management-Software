<?php
/* 
@author psindhu@luc.edu
 */
    session_start();
    include('InboxFetch.php');
?>

<div class="inbox-right">
         	
<div class="mailbox-content">
    <table class="table">
        <tbody>
           <tr><span>E-mails older than 30 days will be automatically deleted</span></tr>
            <?php
            foreach($deletStatusResult as $row)
            {?>
           <tr class="table-row">
               <td class="table-text">
                   <?php echo $row['Email']."(".$row['Privilege'].")"; ?>
               </td>
                <td class="table-text">
                    <span style="text-align: center;color:#999;">
                     <?php echo $row['Subject'] ?>
                    </span>
                </td>
                <td class="march">
                    <?php echo $row['Date'] ?>
                </td>
            </tr>
            <?php }?>
        </tbody>
    </table>
   </div>
</div>