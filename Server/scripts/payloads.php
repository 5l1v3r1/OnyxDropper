<?php
// This file contains functions used in /payloads.php

function GetAllPayloads($conn)
{
    $sql = "SELECT * FROM `payloads` ";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    if($result)
    {
        $payloadTable = $stmt->fetchAll();    
        return $payloadTable;
    }

    return null;
}

function UploadPayload($conn, $base64, $filename)
{
    $sql = "INSERT INTO `payloads` (`Name`, `PayloadBytes`) VALUES ('$filename','$base64')";
    $stmt = $conn->prepare($sql);    
    $stmt->execute();
}

?>