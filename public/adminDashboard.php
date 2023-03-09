<?php 
    include("./dbConnection.php");
    if($_SESSION['user_role'] != '' && ($_SESSION['user_role'] == 'admin' || $_SESSION['user_role'] =='user')){
        // session_destroy();
        // echo '<pre>';
        // var_dump($_SESSION);
        // echo '</pre>';
?>
<!DOCTYPE html>
    <html>
        <head>
            <title>ibuy Admin Dashboard</title>
            <link rel="stylesheet" href="ibuy.css" />
        </head>

        <body>
            <section class="addAuction-main">
                <section class="logo">
                    <a href="./index.php">
                        <h1>
                            <span class="i">i</span><span class="b">b</span><span class="u">u</span
                            ><span class="y">y</span>
                        </h1>
                    </a>
                </section>
                <div class="addAuction">
                    <div class="top">
                        <h2><?php echo ucfirst($_SESSION['user_role']) ?> Dashboard</h2>
                    </div>
                    <div class="admin-dashboard">
                        <div class="all-links">
                            <?php if($_SESSION['user_role'] == 'admin'){ ?>
                                <a href="./manageAdmins.php" class="btn btn-links"> Manage Admins </a>
                                <a href="./adminCategories.php" class="btn btn-links"> Manage Categories </a>
                            <?php } ?>
                            <a href="./manageAuction.php" class="btn btn-links"> Manage Auction </a>
                            <a href="./logout.php" class="btn btn-links"> Logout </a>
                        </div>
                    </div>
                </div>
            </section>
        </body>
    </html>
        <?php
    }else{
        header("Location: ./login.php");
    }

?>