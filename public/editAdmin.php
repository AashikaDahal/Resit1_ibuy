<?php 
    include("./dbConnection.php");
    if($_SESSION['user_role'] != '' && $_SESSION['user_role'] == 'admin'){
        $id = $conn->real_escape_string($_GET['id']);
        $getUsersDataSql = "SELECT * FROM `tbl_users` WHERE `id` ='$id'";
        $result = $conn->query($getUsersDataSql);
        $data = $result->fetch_assoc();
        //  echo
?>
<!DOCTYPE html>
    <html>
        <head>
            <title>ibuy Edit Categories</title>
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
                        <h2>Edit Admin</h2>
                        <a href="./manageAdmins.php"> <- Back </a>
                    </div>
                    <div class="addAuction-form">
                        
                    <div class="form">
                        <form action="./operation/login_register_operation.php" autocomplete="off" method="POST">
                            <input type="hidden" name="action" value="register">
                            <div class="form-group">
                                <label for="name" >Full Name : </label>
                                <input type="text" name="name" id="name" value="<?php echo $data['fullname'] ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="email" >Email : </label>
                                <input type="email" name="email" id="email" value="<?php echo $data['email'] ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Password : </label>
                                <input type="password" name="password"  id="password" required>
                            </div>
                            <div class="btn-group">
                                <button class="btn btn-submit" type="submit">Update Admin</button>
                            </div>
                        </form>
                    </div>
                    
                </div>
            </section>
        </body>
    </html>
    <?php }else{
    header("Location: ./login.php");
}
?>