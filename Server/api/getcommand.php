

<?php

include('../database/db-config.php');
include('../database/db-conn.php');

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
    
}

$mac = $_POST['mac'];
$id = GetclientId($dbconn, $mac)[0]["Id"];




?>