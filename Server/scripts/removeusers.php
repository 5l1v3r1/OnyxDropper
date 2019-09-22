<?php

function GetAllUsers($conn)
{
    $sql = "SELECT * FROM `users`";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    if($result)
    {
        $onlineClientTable = $stmt->fetchAll();    
        return $onlineClientTable;
    }

}

function CheckIfIsLastClient($conn)
{
    $users = GetAllUsers($conn);
    if(count($users) > 1)
    {
        return false;
    }

    return true;
}

function RemoveUser($conn, $id)
{
    $sql = "DELETE FROM `users` WHERE `users`.`Id` = ". $id;
    $stmt = $conn->prepare($sql);
    try
    {
        $stmt->execute();
        return true;
    }
    catch(PDOException $ex)
    {
        return false;
    }
}

?>