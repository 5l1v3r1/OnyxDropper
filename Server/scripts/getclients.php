<?php

// This file contains functions used in /index.php

function GetOnlineClients($conn)
{
    $sql = "SELECT * FROM clients WHERE LastSeen > ADDDATE(NOW(), INTERVAL -15 MINUTE)";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    if($result)
    {
        $onlineClientTable = $stmt->fetchAll();    
        return $onlineClientTable;
    }

    return null;
}

function GetAllClients($conn)
{
    $sql = "SELECT * FROM clients";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    if($result)
    {
        $clientTable = $stmt->fetchAll();    
        return $clientTable;     
    }

    return null;
}


?>