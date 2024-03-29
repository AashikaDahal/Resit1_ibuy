<?php 
    include("../dbConnection.php");
    $today = date("Y-m-d H:i:s"); 
    $userEmail = $_SESSION["user_email"];

    if(isset($_POST['action'])){
        if($_POST['action'] == 'add') {
            $categoryName =  ucfirst($conn -> $_POST['category_name']));

            //creating Table tbl_uses 
            $sqlCreateCategoriesTable = "CREATE TABLE `tbl_categories` ( `id` INT NOT NULL AUTO_INCREMENT , `category_name` VARCHAR(256) NULL , `tbl_used_count` INT(10) DEFAULT 0 , `added_by` VARCHAR(256) NULL , `updated_by` VARCHAR(256) NULL , `added_on` DATETIME NULL , `updated_on` DATETIME NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;";
            $createTableCategories = $conn ->query($sqlCreateCategoriesTable);
        
            $sqlCheckCategoryExists = "SELECT * FROM `tbl_categories` WHERE category_name = '$categoryName'";
            $checkCategoryExists = $conn ->query($sqlCheckCategoryExists);
        
            if($checkCategoryExists->rowCount() >= 1) {
                // echo 'working with email';
                $_SESSION['error_message'] ="Category Already Exit";
                echo '<script>window.location.href="' . $_SERVER['HTTP_REFERER'] . '";</script>';
            }else{
                $sqlInsertCategory = "INSERT INTO `tbl_categories`(`category_name`,`tbl_used_count`,`added_by`,`added_on`) VALUES ('$categoryName',0,'$userEmail','$today')";
                $insertCategory = $conn ->query($sqlInsertCategory);
        
                if($insertCategory){
                    $_SESSION['error_message'] ="Category Added Successfully";
                    header("Location: ../adminCategories.php");
                }else{
                    $_SESSION['error_message'] ="Category Not Added";
                    echo '<script>window.location.href="' . $_SERVER['HTTP_REFERER'] . '";</script>';
                }
            }
        }
        if($_POST['action'] == 'update'){
            $id = $_POST['id'];
            $categoryName =  ucfirst($conn -> $_POST['category_name']));

            $sqlCheckCategoryExists = "SELECT * FROM `tbl_categories` WHERE  category_name = '$categoryName' AND id != '$id'";
            $checkCategoryExists = $conn ->query($sqlCheckCategoryExists);
        
            if($checkCategoryExists->rowCount() >= 1) {
                $_SESSION['error_message'] ="Category Already Exit";
                echo '<script>window.location.href="' . $_SERVER['HTTP_REFERER'] . '";</script>';
            }else{
                $sqlUpdateCategory = "UPDATE `tbl_categories` SET `category_name` = '$categoryName',`updated_by` = '$userEmail',`updated_on` = '$today' WHERE `id` = '$id'";
                $updateCategory = $conn ->query($sqlUpdateCategory);
               
                // echo $sqlUpdateCategory;
                // echo $updateCategory;
                
                if($updateCategory){
                    $_SESSION['error_message'] ="Category Updated Successfully";
                    header("Location: ../adminCategories.php");
                }else{
                    $_SESSION['error_message'] ="Category Not Added";
                    echo '<script>window.location.href="' . $_SERVER['HTTP_REFERER'] . '";</script>';
                }
            }
        }
    }
    if(isset($_GET['action'])){
        if($_GET['action'] == 'delete'){
            $id = $conn->$_GET['id']);
            $getCategoryDataSql = "SELECT * FROM `tbl_categories` WHERE `id` ='$id'";
            $result = $conn->query($getCategoryDataSql);
            $data = $result->fetch(PDO::FETCH_ASSOC);;

            $count = checkCount("tbl_auctions",$id,'category_id');

            // check if data is used in somewhere else or not
            if($count == NULL || $count == 0){
                $deleteCategoryDataSql = "DELETE FROM `tbl_categories` WHERE `id` ='$id'";
                if($conn->query($deleteCategoryDataSql)==TRUE && $conn->affected_rows > 0){
                    $_SESSION['error_message'] ="Data Delete Successfully";
                    echo '<script>window.location.href="' . $_SERVER['HTTP_REFERER'] . '";</script>';
                }else{
                    $_SESSION['error_message'] ="Sorry Some Technical Error Ocurred";
                    echo '<script>window.location.href="' . $_SERVER['HTTP_REFERER'] . '";</script>';
                }
            }else{
                $_SESSION['error_message'] ="Cannot Delete!! Sorry Data Is Used In Somewhere Else";
                echo '<script>window.location.href="' . $_SERVER['HTTP_REFERER'] . '";</script>';
            }
        }
    }
?>