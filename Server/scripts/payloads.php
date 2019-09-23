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

function UploadPayload($conn, $base64, $filename,$fileextension, $name)
{
    $sql = "INSERT INTO `payloads` (`FileName`,`Extension`,`Name`, `PayloadBytes`) VALUES ('$filename','$fileextension','$name','$base64')";
    $stmt = $conn->prepare($sql);    
    $stmt->execute();
}

function RemovePayload($conn, $ids)
{
    foreach ($ids as $id => $value) {
        $sql = "DELETE FROM `payloads` WHERE `payloads`.`Id` =" .$value . ";";        
        $stmt = $conn->prepare($sql);
        $stmt->execute();
    }
}

?>