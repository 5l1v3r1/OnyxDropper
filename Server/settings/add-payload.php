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
    $target_dir = "../uploads/";
    $target_file = $target_dir . basename($_FILES["payloadupload"]["name"]);
    $filename = $_FILES['payloadupload']['name'];
    $name = $_POST['filename'];

    if($_FILES['payloadupload']['error'] == 1)
    {
        // File to large
        $_SESSION['toolarge'] = true;
        header('Location: /add-payload.php');
        die();
    }
    
    if(!move_uploaded_file($_FILES['payloadupload']['tmp_name'],$target_file))
    {
        // Other errors
        $_SESSION['moveerror'] = true;
        header('Location: /settings/add-payload.php');     
        die();
    }
    
    $img = file_get_contents($target_file);
    $base64file = base64_encode($img);     
    $ext = pathinfo($target_file, PATHINFO_EXTENSION);

    try
    {
        UploadPayload($dbconn, $base64file, $filename,$ext, $name);        
    }
    catch(Throwable $th)
    {

    }

    $_SESSION['succes'] = true;
    header('Location: /settings/add-payload.php');     
    die();
            
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
                if(isset($_SESSION['toolarge']))
                {
                    echo("<div class=\"notification is-warning\"> Your file is too large </div>");
                    unset($_SESSION['toolarge']);
                } 

                if(isset($_SESSION['moveerror']))
                {
                    echo("<div class=\"notification is-warning\"> Error moving the file to the upload directory </div>");
                    unset($_SESSION['moveerror']);
                } 

                if(isset($_SESSION['binaryryerror']))
                {
                    echo("<div class=\"notification is-warning\"> Error getting the file bytes </div>");
                    unset($_SESSION['binaryryerror']);
                } 

                if(isset($_SESSION['succes']))
                {
                    echo("<div class=\"notification is-primary\"> Uploaded your payload! </div>");
                    unset($_SESSION['succes']);
                } 
                ?>
                <div class="columns">
                    <div class="column is-3">
                        <?php include('../includes/settings-menu.php') ?>
                    </div>
                    <div class="column">
                        <div class="columns is-multiline">
                            <div class="column is-12">
                                <h1 class="title">Add new payload</h1>

                                <form action="/settings/add-payload.php" method="post" enctype="multipart/form-data">

                                    <div class="columns is-gapless">
                                        <div class="column is-4">
                                            <div class="field">
                                                <label class="label">Upload your file</label>
                                                <div class="control" id="file-js-example">
                                                    <label class="file-label">
                                                        <input class="file-input" name="payloadupload" type="file" class="input" required>
                                                        <span class="file-cta">
                                                            <span class="file-icon">
                                                                <i class="fas fa-upload"></i>
                                                            </span>
                                                            <span class="file-label">
                                                                Choose a file…
                                                            </span>
                                                        </span>
                                                        <span class="file-name">
                                                            No file uploaded
                                                        </span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>         
                                        <div class="column is-3">                                            
                                            <label class="label">Give your file a name</label>                                                
                                            <input type="text" name="filename" placeholder="Enter a name" class="input" required>                                                
                                        </div>                                    
                                        <div class="column">
                                        <label class="label"> </label>     
                                            <button type="submit" class="button is-primary">Upload</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="column is-12">
                                <h1 class="title">Your payloads</h1>
                                <table class="table is-fullwidth is-striped">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>File name</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($payloadTable as $key => $table) 
                                        {                                    
                                        echo("<tr>");
                                        echo("<td>". $table['Id'] ."</td>");
                                        echo("<td>". $table['Name'] ."</td>"); 
                                        echo("<td>". $table['FileName'] ."</td>");
                                        echo("</tr>");
                                        }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
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