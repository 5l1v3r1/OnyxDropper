<?php

session_start();
if(isset($_SESSION['user']))
{
    header('Location: /');
}

if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    // Login the user

    include('./database/db-conn.php');
    $username = htmlspecialchars($_POST['username']);    

    $sql = "SELECT id, username, password FROM Users WHERE Username = '" . $username . "'";
    $stmt = $dbconn->prepare($sql);
    $stmt->execute();

    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);

    if($result == true)
    {
        $input_password = $_POST['password'];
        $db_result = $stmt->fetchAll();
        
        $db_password = $db_result[0]["password"];
        
        if(password_verify($input_password, $db_password))
        {
            $_SESSION['user'] = $db_result[0]["username"];
            header('Location: /');
            die();
        }
        else
        {
            $_SESSION['failed_login'] = true;
            unset($_SESSION['user']);
        }
    }
    else
    {
        $_SESSION['othererr'] = true;
    }
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
            <section class="section">
                <div class="columns is-centered">
                    <div class="column is-5">
                        <?php
                        if(isset($_SESSION['failed_login']))
                        {
                            echo("<div class=\"notification is-warning\">Incorrect username & password combination. </div>");
                            session_destroy();
                        }
                        if(isset($_SESSION['othererr']))
                        {
                            echo("<div class=\"notification is-warning\">We got a error we didn't expect there to be. </div>");
                            session_destroy();
                        }
                        ?>
                        <form action="login.php" method="post">
                            <div class="field">
                                <label class="label">Username</label>
                                <div class="control">
                                    <input class="input" name="username" type="text" placeholder="Enter your username" required>
                                </div>
                            </div>
                            <div class="field">
                                <label class="label">Password</label>
                                <div class="control">
                                    <input class="input" name="password" type="password" placeholder="Enter your password" required>
                                </div>
                            </div>
                            <br>
                            <button type="submit" class="button is-primary is-fullwidth">Login</button>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </main>
    <script type="text/javascript" src="./js/menu.js"></script>
</body>

</html>