<?php 
    include("../dbConnection.php");
    $today = date("Y-m-d H:i:s"); 
    if($_SESSION['user_role'] != '' && $_SESSION['user_email'] !=''){
        $userEmail = $_SESSION["user_email"];

        if(isset($_POST['action'])){
            if($_POST['action'] == 'add') {
                // var_dump($_POST);
                $productId =  ucfirst($_POST['id']);
                $review =  ucfirst( $_POST['review-text']);
                $userId =  ucfirst( $_SESSION['user_id']);

                
                $sqlInsertReview = "INSERT INTO `tbl_review`(`product_id`,`user_id`,`review`,`added_by`,`added_on`) VALUES ('$productId',$userId,'$review','$userEmail','$today')";
                $insertReview = $conn ->query($sqlInsertReview);
        
                // var_dump($sqlInsertReview);
                if($insertReview){
                    $_SESSION['error_message'] ="Review Added Successfully";
                    echo '<script>window.location.href="' . $_SERVER['HTTP_REFERER'] . '";</script>';
                }else{
                    $_SESSION['error_message'] ="Review Not Added";
                    echo '<script>window.location.href="' . $_SERVER['HTTP_REFERER'] . '";</script>';
                }

            }
        }
        if(isset($_GET['action'])){
            if($_GET['action'] == 'delete'){
                $id = $_GET['id'];
                $deleteSql = "DELETE FROM tbl_review WHERE id = '$id'";
                if($conn->query($deleteSql)==TRUE && $conn->affected_rows > 0){
                    $_SESSION['error_message'] ="Data Delete Successfully";
                    echo '<script>window.location.href="' . $_SERVER['HTTP_REFERER'] . '";</script>';
                }else{
                    $_SESSION['error_message'] ="Sorry Some Technical Error Ocurred";
                    echo '<script>window.location.href="' . $_SERVER['HTTP_REFERER'] . '";</script>';
                }
            }
        }
    }else{
        $_SESSION['error_message'] ="Please Login First";
        echo '<script>window.location.href="' . $_SERVER['HTTP_REFERER'] . '";</script>';
    }
?>