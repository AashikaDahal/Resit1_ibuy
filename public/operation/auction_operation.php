<?php 

include("../dbConnection.php");
$today = date("Y-m-d H:i:s"); 
$userEmail = $_SESSION["user_email"];
if(isset($_POST["action"])){
    if($_POST["action"] == "add"){
        $title =  $_POST['title'];
        $description =  $_POST['description'];
        $endDate = $_POST['endDate'];
        $category =  $_POST['category'];
        $price =   $_POST['price'];
        //real_escape_string function is a guard measure used to prevent Sql problems like attacks.
        
        
        $sqlCheckAuctionExists = "SELECT * FROM `tbl_auctions` WHERE title = '$title'";
        $checkAuctionExists = $conn ->query($sqlCheckAuctionExists);

        if($checkAuctionExists->rowCount() >= 1) {
            $_SESSION['error_message'] ="Title Already Exit";
            echo '<script>window.location.href="' . $_SERVER['HTTP_REFERER'] . '";</script>';
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
                echo '<script>window.location.href="' . $_SERVER['HTTP_REFERER'] . '";</script>';
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
        $id =   $_POST['id'];
        $title =   $_POST['title'];
        $description =  $_POST['description'];
        $endDate =  $_POST['endDate'];
        $category =   $_POST['category'];
        $price =  $_POST['price'];

        $sqlCheckAuctionExists = "SELECT * FROM `tbl_auctions` WHERE title = '$title' AND id != '$id";
        $checkAuctionExists = $conn ->prepare($sqlCheckAuctionExists);
        $checkAuctionExists ->execute();
        if($checkAuctionExists->rowCount() >= 1) {
            $_SESSION['error_message'] ="Title Already Exit";
            echo '<script>window.location.href="' . $_SERVER['HTTP_REFERER'] . '";</script>';
            //tbl_auctions is table 'title' is equal to $title.
            //id colume not equal to $id.
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
                    echo '<script>window.location.href="' . $_SERVER['HTTP_REFERER'] . '";</script>';
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
                echo '<script>window.location.href="' . $_SERVER['HTTP_REFERER'] . '";</script>';
            }
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
            echo '<script>window.location.href="' . $_SERVER['HTTP_REFERER'] . '";</script>';
        }else{
            $_SESSION['error_message'] ="Sorry Some Technical Error Ocurred";
            echo '<script>window.location.href="' . $_SERVER['HTTP_REFERER'] . '";</script>';
        }
        
    }

}
}
?>