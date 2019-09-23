<?php

function CheckIfUserExists($macaddr, $conn)
{
    $sql = "SELECT * FROM `clients` WHERE `MacAddr` = '$macaddr'";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    if($stmt->RowCount() > 0 )
    {
        return true;
    }
    else
    {
        return false;
    }
}

include('../database/db-config.php');
include('../database/db-conn.php');

if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    if(!isset($_POST['mac']))
    {
        $msg = array('Error' => 'No data was sent');
        echo(json_encode($msg));
        die();
    }

    $macaddr = $_POST['mac'];
    if(CheckIfUserExists($macaddr, $dbconn))
    {
        $msg = array('Message' => 'succes');
        echo(json_encode($msg));
        die();
    }
    else
    {
        $msg = array('Message' => 'fail');
        echo(json_encode($msg));
        die();
    }    
}
else
{
    header('Location: / ');
}
?>