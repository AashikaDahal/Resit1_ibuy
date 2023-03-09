<?php 
    include("../dbConnection.php");
    $today = date("Y-m-d H:i:s"); 
    if($_SESSION['user_role'] != '' && $_SESSION['user_email'] !=''){
        $userEmail = $_SESSION["user_email"];
    
        if(isset($_POST['action'])){
            if($_POST['action'] == 'add') {
                // var_dump($_POST);
                $productId =  ucfirst($conn -> real_escape_string($_POST['id']));
                $price =  ucfirst($conn -> real_escape_string($_POST['bid']));
                $userId =  ucfirst($conn -> real_escape_string($_SESSION['user_id']));
              //The first line checks if the 'action' parameter in the submitted form data is set to 'add'.
              //code extracts the values of the 'id', 'bid', and 'user_id' parameters from the $_POST and $_SESSION  arrays only if the condition is true.

              

                
            
                $sqlInsertBids = "INSERT INTO `tbl_bids`(`product_id`,`user_id`,`price`,`added_by`,`added_on`) VALUES ('$productId',$userId,'$price','$userEmail','$today')";
                $insertBids = $conn ->query($sqlInsertBids);
        
                // var_dump($sqlInsertBids);
                //I tried using the var_dump but it did not work.
                if($insertBids){
                    $_SESSION['error_message'] ="Bids Added Successfully";
                    header("Location: " . $_SERVER['HTTP_REFERER']);
                }else{
                    $_SESSION['error_message'] ="Bids Not Added";
                    header("Location: " . $_SERVER['HTTP_REFERER']);
                }
    
            }
        }
        if(isset($_GET['action'])){
            if($_GET['action'] == 'delete'){
                $id = $_GET['id'];
                $deleteSql = "DELETE FROM  tbl_bids WHERE id = '$id'";
                if($conn->query($deleteSql)==TRUE && $conn->affected_rows > 0){
                    $_SESSION['error_message'] ="Data Delete Successfully";
                    header("Location: " . $_SERVER['HTTP_REFERER']);
                }else{
                    $_SESSION['error_message'] ="Sorry Some Technical Error Ocurred";
                    header("Location: " . $_SERVER['HTTP_REFERER']);
                    //The first line checks if the 'action' parameter is set in the URL query string using the $_GET array.
                    //Second line checks the "action" parameter is deleted or not.
                    //Connection of database is also shown is the code.
                    //
                }
            }
        }

    }else{
        $_SESSION['error_message'] ="Please Login First";
        header("Location: " . $_SERVER['HTTP_REFERER']);
    }
?>