<?php

// This script contains functions used in /add-user.php

function UserExists($conn, $username)
{
    $sql = "SELECT * FROM `users` WHERE `username`= '".$username."'";
    $result = $conn->prepare($sql);
    $result->execute();
    if($result->rowCount() > 0)
    {
        return true;
    }

    return false;
}

function CreateUser($username, $password, $conn)
{
    $hpassword = password_hash($password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO `users`(`Username`, `Password`) VALUES (\"".$username."\",\"".$hpassword."\")";
    try {
        $result = $conn->prepare($sql);
        $result->execute();
        return true;
    } catch (\Throwable $th) {
        return false;
    }
}


?>