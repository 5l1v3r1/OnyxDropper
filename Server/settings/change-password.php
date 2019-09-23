<?php
session_start();

include('../database/db-config.php');
include '../database/db-conn.php';

if (!isset($_SESSION['user'])) {    
    header('location: ' . "/login.php");
    exit();
}

if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    if(isset($_POST['password']) || isset($_POST['newpassword'] ))
    {        
        $password = $_POST['password'];
        $passwordcon = $_POST['newpassword'];

        if($password != $passwordcon)
        {
            $_SESSION['failsetpws'] = true;
        }
        else
        {
            $sql = "UPDATE `users` SET `Password` = '" . password_hash($password, PASSWORD_DEFAULT) . "' WHERE `Username` = '". $_SESSION['user'] ."'";
            $stmt = $dbconn->prepare($sql);
            $stmt->execute();

            if($stmt->rowCount() > 0)
            {
                $_SESSION['pws-change-success'] = true;
            }
            else
            {
                $_SESSION['failsetpws'] = true;
            }
        }
    }
}
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
                if(isset($_SESSION['failsetpws']))
                {
                    echo("<div class=\"notification is-warning\"> Error in changing your password </div>");
                }
                elseif(isset($_SESSION['pws-change-success']))
                {
                    echo("<div class=\"notification is-success\"> Password changed succesfully! </div>");
                }                
                unset($_SESSION['failsetpws']);
                unset($_SESSION['pws-change-success']);
                ?>
                <div class="columns">
                    <div class="column is-3">                        
                        <?php include('../includes/settings-menu.php') ?>
                    </div>
                    <div class="column">                                        
                        <div class="columns is-centered">                        
                            <div class="column is-6">
                            <h1 class="title">Change your password</h1>   
                                <!-- Change password form -->                               
                                <form action="change-password.php" method="post">                                    
                                    <div class="field">
                                        <label class="label">Password</label>
                                        <div class="control">
                                            <input class="input" name="password" type="password"
                                                placeholder="Text input">
                                        </div>
                                    </div>
                                    <div class="field">
                                        <label class="label">Confirm password</label>
                                        <div class="control">
                                            <input class="input" name="newpassword" type="password"
                                                placeholder="Text input">
                                        </div>
                                    </div>
                                    <button class="button is-primary" type="submit">Change password</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>
    <script type="text/javascript" src="./js/index.js"></script>
</body>

</html>