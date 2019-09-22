<?php
session_start();

include './database/db-conn.php';
include './scripts/payloads.php';

if (!isset($_SESSION['user'])) {
    echo ("not set.");
    header('location: ' . "/login.php");
    exit();
}

if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    if($_FILES['payloadupload']['error'] == 1)
    {
        // File to large
        $_SESSION['toolarge'] = true;
        header('Location: /add-payload.php');
        die();
    }

    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["payloadupload"]["name"]);

    if(!move_uploaded_file($_FILES['payloadupload']['tmp_name'],$target_file))
    {
        // File to large
        $_SESSION['weirderror'] = true;
        header('Location: /add-payload.php');
        die();
    }
    $filename = $_FILES['payloadupload']['name'];

    $img = file_get_contents($target_file);
    $base64file = base64_encode($img);
    
    UploadPayload($dbconn, $base64file, $filename);
    
}

$payloadTable = GetAllPayloads($dbconn);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include './includes/head.php';?>
</head>

<body>
    <header>
        <?php include './includes/header.php';?>
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

                if(isset($_SESSION['weirderror']))
                {
                    echo("<div class=\"notification is-warning\"> An unexpected error occured </div>");
                    unset($_SESSION['weirderror']);
                } 
                ?>
                <div class="columns">
                    <div class="column is-3">
                        <?php include('./includes/settings-menu.php') ?>
                    </div>
                    <div class="column">
                        <div class="columns is-multiline">
                            <div class="column is-12">
                                <h1 class="title">Add new payload</h1>

                                <form action="add-payload.php" method="post" enctype="multipart/form-data">
                                    <div id="file-js-example" class="file has-name">
                                        <label class="file-label">                                            
                                            <input class="file-input" type="file" name="payloadupload">
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
                                        <button class="button is-primary">Upload</button>
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
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            foreach ($payloadTable as $key => $table) 
                                        {                                    
                                        echo("<tr>");
                                        echo("<td>". $table['Id'] ."</td>");
                                        echo("<td>". $table['Name'] ."</td>"); 
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