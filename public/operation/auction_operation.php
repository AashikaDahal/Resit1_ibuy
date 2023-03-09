<?php 

include("../dbConnection.php");
$today = date("Y-m-d H:i:s"); 
$userEmail = $_SESSION["user_email"];
if(isset($_POST["action"])){
    if($_POST["action"] == "add"){
        $title =  $conn -> real_escape_string($_POST['title']);
        $description =  $conn -> real_escape_string($_POST['description']);
        $endDate =  $conn -> real_escape_string($_POST['endDate']);
        $category =  $conn -> real_escape_string($_POST['category']);
        $price =  $conn -> real_escape_string($_POST['price']);
        //real_escape_string function is a guard measure used to prevent Sql problems like attacks.
        // echo $endDate;
        // exit();
        //$sqlCreateTaleAuctions = "CREATE TABLE `tbl_auctions` ( `id` INT NOT NULL AUTO_INCREMENT , `title` VARCHAR(256) NULL , `description` TEXT NULL , `category_id` INT(10) NULL ,`endDate` DATETIME NULL,`price` DECIMAL(10,2) NULL, `photo_location` VARCHAR(256) NULL , `photo_name` VARCHAR(256) NULL , `tbl_used_count` INT(10) DEFAULT 0 , `added_by` VARCHAR(256) NULL , `updated_by` DATETIME NULL , `added_on` VARCHAR(256) NULL , `updated_on` DATETIME NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;";
        //$createTableAuctions = $conn->query($sqlCreateTaleAuctions);

        $sqlCheckAuctionExists = "SELECT * FROM `tbl_auctions` WHERE title = '$title'";
        $checkAuctionExists = $conn ->query($sqlCheckAuctionExists);

        if($checkAuctionExists->num_rows >= 1) {
            $_SESSION['error_message'] ="Title Already Exit";
            header("Location: " . $_SERVER['HTTP_REFERER']);
        }
        $image =  $_FILES['image'];
        $imageNames = $_FILES['image']['name'];
        $imageTempNames = $_FILES['image']['tmp_name'];
        $imageName =  explode(".", $imageNames)[0];
        $imageExtension =  explode(".", $imageNames)[1];
        $photoNameAndExtension = $imageName .'_'.time().'.'.$imageExtension;
        // $photoName =  time().'.'.$imageExtension;
        $photoLocation = "../public/images/auctions/";
        $photoLocation1 = "./public/images/auctions/";
        $fileName = "../public/images/auctions/".$photoNameAndExtension;
     //Photo location allows to located the image needed.

        if(!file_exists($photoLocation)){
            mkdir($photoLocation, 0777, true);
        }


        if(move_uploaded_file($imageTempNames,$fileName)){
            $sqlInsertAuction = "INSERT INTO `tbl_auctions`(`title`, `description`, `category_id`,`endDate`,`price`, `photo_location`, `photo_name`,`tbl_used_count`,`added_by`,`added_on`) VALUES ('$title', '$description', '$category','$endDate','$price','$photoLocation1', '$photoNameAndExtension',0, '$userEmail', '$today')";
            $insertAuction = $conn -> query($sqlInsertAuction);
            if($insertAuction){
                // countPlus("tbl_categories", $category);
                $_SESSION['error_message'] ="Category Added Successfully";
                header("Location: ../manageAuction.php");
            }else{
                $_SESSION['error_message'] ="Category Added Successfully";
                header("Location: " . $_SERVER['HTTP_REFERER']);
                //The first line tries to move an uploaded file to the specified directory using the move_uploaded_file function.
                //$sqlInsertAuction-variable contains a SQL query to insert some data into a database table called 'tbl_auctions'.
            }

        }
    }
    if($_POST["action"] == "edit"){
        echo "<pre>";
        var_dump($_POST);
        echo "----------------------------------------------------------------";
        var_dump($_FILES);
        echo "</pre>";
        $id =  $conn -> real_escape_string($_POST['id']);
        $title =  $conn -> real_escape_string($_POST['title']);
        $description =  $conn -> real_escape_string($_POST['description']);
        $endDate =  $conn -> real_escape_string($_POST['endDate']);
        $category =  $conn -> real_escape_string($_POST['category']);
        $price =  $conn -> real_escape_string($_POST['price']);

        $sqlCheckAuctionExists = "SELECT * FROM `tbl_auctions` WHERE title = '$title' AND id != '$id";
        $checkAuctionExists = $conn ->query($sqlCheckAuctionExists);

        if($checkAuctionExists->num_rows >= 1) {
            $_SESSION['error_message'] ="Title Already Exit";
            header("Location: " . $_SERVER['HTTP_REFERER']);
        }
        if($_FILES['image']['name'] != ''){
            $image =  $_FILES['image'];
            $imageNames = $_FILES['image']['name'];
            $imageTempNames = $_FILES['image']['tmp_name'];
            $imageName =  explode(".", $imageNames)[0];
            $imageExtension =  explode(".", $imageNames)[1];
            $photoNameAndExtension = $imageName .'_'.time().'.'.$imageExtension;
            // $photoName =  time().'.'.$imageExtension;
            $photoLocation = "./public/images/auctions/";
            $fileName = "../public/images/auctions/".$photoNameAndExtension;
    
    
            if(!file_exists($photoLocation)){
                mkdir($photoLocation, 0777, true);
            }
            // unlink()
            if(move_uploaded_file($imageTempNames,$fileName)){
                $sqlUpdateAuction = "UPDATE `tbl_auctions` SET `title` = '$title', `description` ='$description', `category_id` = $category,`endDate` = '$endDate', `price` = '$price', `photo_location`= '$photoLocation', `photo_name`= '$photoNameAndExtension',`updated_by` = '$userEmail',`updated_on` = '$today' WHERE id = '$id'";
                $updateAuction = $conn -> query($sqlUpdateAuction);
                if($updateAuction){
                    // countPlus("tbl_categories", $category);
                    $_SESSION['error_message'] ="Auction Updated Successfully";
                    header("Location: ../manageAuction.php");
                }else{
                    $_SESSION['error_message'] ="Sorry, something went wrong!!";
                    header("Location: " . $_SERVER['HTTP_REFERER']);
                    //The function move_uploaded_file tries to move an uploaded file to the specified directory.
                }
            }
        }else{
            $sqlUpdateAuction = "UPDATE `tbl_auctions` SET `title` = '$title', `description` ='$description', `category_id` = $category,`endDate` = '$endDate',`price` = '$price', `updated_by` = '$userEmail',`updated_on` = '$today' WHERE id = '$id'";
            $updateAuction = $conn -> query($sqlUpdateAuction);
            if($updateAuction){
                // countPlus("tbl_categories", $category);
                $_SESSION['error_message'] ="Auction Updated Successfully";
                header("Location: ../manageAuction.php");
            }else{
                $_SESSION['error_message'] ="Sorry, something went wrong!!";
                header("Location: " . $_SERVER['HTTP_REFERER']);
            }
        }
        // echo "i am here: ";
        // if($updateAuction){
        //     // countPlus("tbl_categories", $category);
        //     $_SESSION['error_message'] ="Auction Updated Successfully";
        //     header("Location: ../manageAuction.php");
        // }else{
        //     $_SESSION['error_message'] ="Sorry, something went wrong!!";
        //     header("Location: " . $_SERVER['HTTP_REFERER']);
        // }
    }

}
if(isset($_GET["action"])){
    if($_GET["action"] == "delete"){
        $id = $_GET["id"];
        // $checkRelatedTable = $conn->query("SELECT * FROM  WHERE
        $deleteAuctionSql = "DELETE FROM `tbl_auctions` WHERE `id` = '$id'";
        if($conn->query($deleteAuctionSql)==TRUE && $conn->affected_rows > 0){
            // countMinus("tbl_categories", $category);
            $_SESSION['error_message'] ="Data Delete Successfully";
            header("Location: " . $_SERVER['HTTP_REFERER']);
        }else{
            $_SESSION['error_message'] ="Sorry Some Technical Error Ocurred";
            header("Location: " . $_SERVER['HTTP_REFERER']);
        }
        
    }

}

?>