<?php
session_start();

include './database/db-conn.php';
include './scripts/removeusers.php';

if (!isset($_SESSION['user'])) {
    echo ("not set.");
    header('location: ' . "/login.php");
    exit();
}

if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    if(!isset($_POST['check']))
    {
        $_SESSION['nouserset'] = true;
        header('Location: /remove-user.php');
        die();
    }

    if(CheckIfIsLastClient($dbconn))
    {
        $_SESSION['lastuser'] = true;
        header('Location: /remove-user.php');
        die();
    }

    $userid = $_POST['check'][0];
    if(RemoveUser($dbconn, $userid))
    {
        $_SESSION['rmsuccess'] = true;
    }
    else
    {
        $_SESSION['rmfail'] = true;
    }
}

$userTable = GetAllUsers($dbconn);

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
                
                if(isset($_SESSION['lastuser']))
                {
                    echo("<div class=\"notification is-warning\"> You cannot delete the last user </div>");
                    unset($_SESSION['lastuser']);
                }

                if(isset($_SESSION['nouserset']))
                {
                    echo("<div class=\"notification is-warning\"> Please select at least one user you want to remove </div>");
                    unset($_SESSION['nouserset']);
                }

                if(isset($_SESSION['rmsuccess']))
                {
                    echo("<div class=\"notification is-success\"> Removed the user </div>");
                    unset($_SESSION['rmsuccess']);
                }

                if(isset($_SESSION['rmfail']))
                {
                    echo("<div class=\"notification is-warning\"> Unable to remove the user </div>");
                    unset($_SESSION['rmfail']);
                }
                
                

                ?>
                <div class="columns">
                    <div class="column is-3">
                        <?php include('./includes/settings-menu.php') ?>
                    </div>
                    <div class="column">
                        <h1 class="title">Remove users</h1>   
                        <form action="" method="post">
                        <table class="table is-fullwidth is-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Username</th>                                                                       
                                    <th>Select</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($userTable as $key => $table) 
                                {                                    
                                    echo("<tr>");
                                    echo("<td>". $table['Id'] ."</td>");
                                    echo("<td>". $table['Username'] ."</td>");                                    
                                    echo("<td> <input type=\"checkbox\" name=\"check[]\" value=". $table['Id'] ."> </td>");
                                    echo("</tr>");
                                }
                                ?>
                            </tbody>
                        </table>
                        <button class="button is-primary">Remove</button>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </main>
    <script type="text/javascript" src="./js/index.js"></script>
</body>

</html>