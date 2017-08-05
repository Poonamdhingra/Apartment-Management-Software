<?php

/* 
@author psindhu@luc.edu
 */

include('dbconnect.php');
try
    {

        $countAll = "SELECT COUNT(*) AS CNT FROM apartments";
        $countAllResult = $pdo->query($countAll);
        foreach($countAllResult as $result){
            $GLOBALS['countAll'] =  $result['CNT'];
        }

        $countLeased = "SELECT COUNT(*) AS CNT FROM apartments WHERE status = 'Leased';";
        $countLeasedResult = $pdo->query($countLeased);
        foreach($countLeasedResult as $result){
            $GLOBALS['countLeased'] =  $result['CNT'];
        }

        $countBlocked = "SELECT COUNT(*) AS CNT FROM apartments WHERE status = 'Blocked';";
        $countBlockedResult = $pdo->query($countBlocked);
        foreach($countBlockedResult as $result){
            $GLOBALS['countBlocked'] =  $result['CNT'];
        }

        $countVacant = "SELECT COUNT(*) AS CNT FROM apartments WHERE status = 'Vacant';";
        $countVacantResult = $pdo->query($countVacant);
        foreach($countVacantResult as $result){
            $GLOBALS['countVacant'] =  $result['CNT'];
        }

        $selectVacant = "SELECT * FROM apartments WHERE status = 'Vacant';";
        $selectVacantResult = $pdo->query($selectVacant);

        $selectBlocked = "SELECT * FROM apartments WHERE status = 'Blocked';";
        $selectBlockedResult = $pdo->query($selectBlocked);

        $selectLeased = "SELECT * FROM apartments WHERE status = 'Leased';";
        $selectLeasedResult = $pdo->query($selectLeased);

        $selectAll = "SELECT * FROM apartments";
        $selectAllResult = $pdo->query($selectAll);
    }
    catch(PDOException $e)
    {
        die("Something happened:" . $e->getMessage());
    }