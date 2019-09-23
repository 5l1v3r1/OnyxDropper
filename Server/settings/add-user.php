<?php
session_start();

include('../database/db-config.php');
include '../database/db-conn.php';
include '../scripts/adduser.php';

if (!isset($_SESSION['user'])) {
    echo ("not set.");
    header('location: ' . "/login.php");
    exit();
}

if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    if(isset($_POST['username']) && isset($_POST['password']) && isset($_POST['confirmpassword'] ))
    {        
        $username = $_POST['username'];
        $password = $_POST['password'];
        $passwordcon = $_POST['confirmpassword'];
        if($password != $passwordcon)
        {
            $_SESSION['failsetpws'] = true;
            header('Location: /add-user.php');
            die();
        }
        
        if(UserExists($dbconn, $_POST['username']))
        {
            // We already have a user with this name
            $_SESSION['alreadyused'] = true;
            header('Location: /add-user.php');
            die();
        }
        if(CreateUser($username, $password, $dbconn))
        {
            $_SESSION['accsucces'] = true;
            header('Location: /add-user.php');
            die();
        }
        else
        {
            $_SESSION['accfail'] = true;
            header('Location: /add-user.php');
            die();
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
                    echo("<div class=\"notification is-warning\"> Passwords do not match </div>");
                    unset($_SESSION['failsetpws']);
                }
                elseif(isset($_SESSION['alreadyused']))
                {
                    echo("<div class=\"notification is-warning\"> Username is already in use </div>");
                    unset($_SESSION['alreadyused']);
                }
                elseif(isset($_SESSION['accsucces']))
                {
                    echo("<div class=\"notification is-success\"> Succesfully created a new account </div>");
                    unset($_SESSION['accsucces']);
                }
                elseif(isset($_SESSION['accfail']))
                {
                    echo("<div class=\"notification is-danger\"> An unexpected error happened </div>");
                    unset($_SESSION['accfail']);
                }
                
                ?>
                <div class="columns">
                    <div class="column is-3">
                        <?php include('../includes/settings-menu.php') ?>
                    </div>
                    <div class="column">
                        <div class="columns is-centered">
                            <div class="column is-6">
                                <h1 class="title">Add a new user</h1>   
                                <!-- Change password form -->                               
                                <form action="add-user.php" method="post">     
                                    <div class="field">
                                        <label class="label">Username</label>
                                        <div class="control">
                                            <input class="input" name="username" type="text"
                                                placeholder="Text input" required>
                                        </div>
                                    </div>                               
                                    <div class="field">
                                        <label class="label">Password</label>
                                        <div class="control">
                                            <input class="input" name="password" type="password"
                                                placeholder="Text input" required>
                                        </div>
                                    </div>
                                    <div class="field">
                                        <label class="label">Confirm password</label>
                                        <div class="control">
                                            <input class="input" name="confirmpassword" type="password"
                                                placeholder="Text input" required>
                                        </div>
                                    </div>
                                    <button class="button is-primary" type="submit">Add user</button>
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