<?php
try
{
    $dbconn = new PDO("mysql:host=$db_host; dbname=$db_name", $db_username, $db_password);
    $dbconn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
}
catch(PDOException $ex)
{
    
}
?>

