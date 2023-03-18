<?php
    include("./dbConnection.php");
    if(isset($_SESSION['error_message'])){
        echo '<script> alert("'.$_SESSION['error_message'].'")</script>';
        unset($_SESSION['error_message']);
    }
    


    // this is for admin login 
    $fullname = "admin";
    $email = 'admin@gmail.com';
    $password = 'admin';
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $sqlCheckEmailExists = "SELECT * FROM `tbl_users` WHERE email = '$email' limit 1";
    $checkEmailExists = $conn ->query($sqlCheckEmailExists);
    //var_dump($checkEmailExists);
    if($checkEmailExists->rowCount() == 1){
        $data = $checkEmailExists->fetch(PDO::FETCH_ASSOC);
        if(!password_verify($password, $data['hashed_password'])){
            $sqlInsertUser = "INSERT INTO `tbl_users` (`fullname`,`email`, `hashed_password`, `role`, `entry_type`)VALUES('$fullname','$email','$hashed_password','admin','Mannual')";
            $insertUserData = $conn -> query($sqlInsertUser);
        }
    }else{
        $sqlInsertUser = "INSERT INTO `tbl_users` (`fullname`,`email`, `hashed_password`, `role`, `entry_type`)VALUES('$fullname','$email','$hashed_password','admin','Mannual')";
        $insertUserData = $conn -> query($sqlInsertUser);
        
    }
?>
<!DOCTYPE html>
<html>
	<head>
		<title>ibuy Auctions</title>
		<link rel="stylesheet" href="ibuy.css" />
	</head>

	<body>
        <section class="register-main">
            <div class="register">
                <div class="top">
                    <h2>Login Your Account</h2>
                </div>
                <div class="register-form">
                <section class="logo">
                    <a href="./index.php">
                        <h1>
                            <span class="i">i</span><span class="b">b</span><span class="u">u</span
                            ><span class="y">y</span>
                        </h1>
                    </a>
                </section>
                    <div class="form">
                        <form action="./operation/login_register_operation.php" method="POST" autocomplete="off">
                            <input type="hidden" name="action" value="signIn">
                            <div class="form-group">
                                <label for="email" >Email : </label>
                                <input type="email" name="email" id="email" required>
                            </div>
                            <div class="form-group">
                                <label for="password" >Password : </label>
                                <input type="password" name="password"  id="password" required>
                            </div>
                            <div class="btn-group">
                                <button class="btn btn-submit" type="submit">Login</button>
                                <p>New Here? Let's go for <a href="./register.php">Register</a></p>
                            </div>
                        </form>
                    </div>
                </div>
                
            </div>
        </section>
    </body>
</html>