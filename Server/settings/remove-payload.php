<?php
session_start();

include('../database/db-config.php');
include '../database/db-conn.php';
include '../scripts/payloads.php';

if (!isset($_SESSION['user'])) {
    echo ("not set.");
    header('location: ' . "/login.php");
    exit();
}

if($_SERVER['REQUEST_METHOD'] == 'POST')
{    
    if(!isset($_POST['check']))
    {
        $_SESSION['checkpyl'] = true;
        header('Location: /remove-payload.php');        
    }    

    RemovePayload($dbconn, $_POST['check']);
}

$payloadTable = GetAllPayloads($dbconn);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include '../includes/head.php';?>
</head>

<body>
    <header>
        <?php include '../includes/header.php';?>
    </header>
    <main>
        <div class="container">
            <section class="section">
                <?php     
                if(isset($_SESSION['checkpyl']))
                {
                    echo("<div class=\"notification is-warning\"> Select a payload to delete </div>");
                    unset($_SESSION['checkpyl']);
                }                 
                ?>
                <div class="columns">
                    <div class="column is-3">
                        <?php include('../includes/settings-menu.php') ?>
                    </div>
                    <div class="column">
                        <h1 class="title">Select a an item to delete</h1>
                        <form action="remove-payload.php" method="post">
                        <table class="table is-fullwidth is-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Select</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    foreach ($payloadTable as $key => $table) 
                                    {                                    
                                    echo("<tr>");
                                    echo("<td>". $table['Id'] ."</td>");
                                    echo("<td>". $table['Name'] ."</td>"); 
                                    echo("<td> <input type=\"checkbox\" name=\"check[]\" value=". $table['Id'] ."> </td>");
                                    echo("</tr>");
                                    }
                                    ?>
                            </tbody>
                        </table>
                        <button class="button is-primary" type="submit">Delete</button>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </main>
    <script type="text/javascript" src="./js/index.js"></script>
    <script>
        const fileInput = document.querySelector('#file-js-example input[type=file]');
        fileInput.onchange = () => {
            if (fileInput.files.length > 0) {
                const fileName = document.querySelector('#file-js-example .file-name');
                fileName.textContent = fileInput.files[0].name;
            }
        }
    </script>
</body>

</html>