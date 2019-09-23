<nav class="navbar" role="navigation" aria-label="main navigation">
    <div class="container">
        <div class="navbar-brand">
            <a class="navbar-item" href="/">
                <h1 class="title">OnyxDropper</h1>
            </a>
            <a role="button" class="navbar-burger burger" aria-label="menu" aria-expanded="false"
                data-target="navbarBasicExample">
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
            </a>
        </div>

        <?php 
        if(isset($_SESSION['user']))
        { ?>
        <div id="navbarBasicExample" class="navbar-menu">
            <div class="navbar-start">
                <a class="navbar-item" href="/">
                    Home
                </a>
                <div class="navbar-item has-dropdown is-hoverable">
                    <p class="navbar-link">
                        Settings
                    </p>
                    <div class="navbar-dropdown">                        
                        <a class="navbar-item" href="/settings/change-password.php">
                            Change password
                        </a>
                        <a class="navbar-item" href="/settings/add-user.php">
                            Add new user
                        </a>
                        <a class="navbar-item" href="/settings/remove-user.php">
                            Remove users
                        </a>                        
                        <br>
                        <a class="navbar-item" href="/settings/add-payload.php">
                            Add payload
                        </a>    
                        <a class="navbar-item" href="/settings/remove-payload.php">
                            Remove payload
                        </a>                       
                    </div>
                </div>                
                <div class="navbar-item">
                    <a class="navbar-item" href="../scripts/logout.php">
                        Logout
                    </a>
                </div>
            </div>
        </div>
        <?php
        } 
        ?>
    </div>
</nav>