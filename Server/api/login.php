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
        $msg = array('error' => 'No data was sent');
        echo(json_encode($msg));
        die();
    }

    $macaddr = $_POST['mac'];
    if(CheckIfUserExists($macaddr, $dbconn))
    {
        $msg = array('message' => 'succes');
        echo(json_encode($msg));
        die();
    }
    else
    {
        $msg = array('message' => 'fail');
        echo(json_encode($msg));
        die();
    }    

    $msg = array('message' => 'error');
    echo(json_encode($msg));
    die();
}
else
{
    header('Location: / ');
}
?>