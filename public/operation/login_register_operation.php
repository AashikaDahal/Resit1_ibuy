<?php 
    include("../dbConnection.php");
    $today = date("Y-m-d H:i:s"); 
     if(isset($_SESSION["user_email"])) {
        $userEmail = $_SESSION["user_email"];
     }else{
        $userEmail = 'self';
     }
    if(isset($_POST['action'])){
        if($_POST['action'] == 'register'){
            $name =  $conn -> real_escape_string($_POST['name']);
            $email =  $conn -> real_escape_string($_POST['email']);
            $password =  $conn -> real_escape_string($_POST['password']);
            $role =  $conn -> real_escape_string($_POST['role']);

            //hashed password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            
                
            $sqlCheckEmailExists = "SELECT * FROM `tbl_users` WHERE email = '$email'";
            $checkEmailExists = $conn ->query($sqlCheckEmailExists);
            
            //check email address already exists
            if($checkEmailExists->num_rows >= 1) {
                // echo 'working with email';
                $_SESSION['error_message'] ="Email Already Exit";
                header("Location: ../register.php");
            }else{
                 $sqlInsertUser = "INSERT INTO `tbl_users` (`fullname`,`email`, `hashed_password`, `role`, `entry_type`, `added_by`,`added_on`)VALUES('$name','$email','$hashed_password','$role','Auto','$userEmail','$today')";
                $insertUserData = $conn -> query($sqlInsertUser);
                
                if($sqlInsertUser){
                    $_SESSION['error_message'] ="New User Added Successfully";
                    if($role == 'admin'){
                        // header("Location: " . $_SERVER['HTTP_REFERER']);
                        // $_SESSION['user_role'] = $role;
                        // $_SESSION['user_id'] = $data['id'];
                        // $_SESSION['user_email'] = $data['email'];
                        header("Location: ../manageAdmins.php");
                    }else{
                        header("Location: ../login.php");
                    }
                }else{
                    $_SESSION['error_message'] ="Sorry Some Issue Ocurred";
                    header("Location: " . $_SERVER['HTTP_REFERER']);
                }
            }
           
        }

        if($_POST['action'] =='signIn'){
            // echo '<pre>';
            // var_dump($_POST);
            // echo '</pre>';

            $email =  $conn -> real_escape_string($_POST['email']);
            $password =  $conn -> real_escape_string($_POST['password']);

            $sqlCheckEmailExists = "SELECT * FROM `tbl_users` WHERE email = '$email' limit 1";
            $checkEmailExists = $conn ->query($sqlCheckEmailExists);

            if($checkEmailExists->num_rows == 1){
                $data = $checkEmailExists->fetch_assoc();
                if(password_verify($password, $data['hashed_password'])){
                    $_SESSION['user_role'] = $data['role'];
                    $_SESSION['user_id'] = $data['id'];
                    $_SESSION['user_email'] = $data['email'];
                    header("Location: ../adminDashboard.php");
                    // if($data['role'] == 'admin'){
                    // }else{
                    //     header("Location: ../userDashboard.php");
                    // }
                }else{
                    $_SESSION['error_message'] ="Sorry wrong password";
                header("Location: " . $_SERVER['HTTP_REFERER']);
                }
            }else{
                $_SESSION['error_message'] ="Sorry wrong email address";
                header("Location: " . $_SERVER['HTTP_REFERER']);
            }



            
        }
    }
    if(isset($_GET['action'])){
        if($_GET['action'] == 'delete'){
            // echo '<pre>';
            // var_dump($_GET);
            // echo '</pre>';

            $id = $conn->real_escape_string($_GET['id']);
            $getUsersDataSql = "SELECT * FROM `tbl_users` WHERE `id` ='$id'";
            $result = $conn->query($getUsersDataSql);
            $data = $result->fetch_assoc();

            // check if data is used in somewhere else or not
            if($data['tbl_used_count'] == NULL || $data['tbl_used_count'] == 0){
                $deleteUserDataSql = "DELETE FROM `tbl_users` WHERE `id` ='$id'";
                if($data['id'] == $_SESSION['user_id']){
                    $_SESSION['user_role'] = '';
                    $_SESSION['user_id'] = '';
                    $_SESSION['user_email'] = '';
                    if($conn->query($deleteUserDataSql)==TRUE && $conn->affected_rows > 0){
                        $_SESSION['error_message'] ="Data Delete Successfully";
                        header("Location: ../login.php");
                    }else{
                        $_SESSION['error_message'] ="Sorry Some Technical Error Ocurred";
                        header("Location: " . $_SERVER['HTTP_REFERER']);
                    }
                }else{
                    if($conn->query($deleteUserDataSql)==TRUE && $conn->affected_rows > 0){
                        $_SESSION['error_message'] ="Data Delete Successfully";
                        header("Location: " . $_SERVER['HTTP_REFERER']);
                    }else{
                        $_SESSION['error_message'] ="Sorry Some Technical Error Ocurred";
                        header("Location: " . $_SERVER['HTTP_REFERER']);
                    }
                }
            }else{
                $_SESSION['error_message'] ="Sorry Data Is Used In Somewhere Else";
                header("Location: " . $_SERVER['HTTP_REFERER']);
            }
        }
    }

?>