<?php 
    include("./dbConnection.php");
    if($_SESSION['user_role'] != '' && ($_SESSION['user_role'] == 'admin' || $_SESSION['user_role'] == 'user')){
        if(isset($_SESSION['error_message'])){
            echo '<script> alert("'.$_SESSION['error_message'].'")</script>';
            unset($_SESSION['error_message']);
        }
        // echo checkCount("tbl_categories", "2");
        $id = $conn->real_escape_string($_GET['id']);
        $getUsersDataSql = "SELECT * FROM `tbl_auctions` WHERE `id` ='$id'";
        $result = $conn->query($getUsersDataSql);
        $data = $result->fetch_assoc();
?>
<!DOCTYPE html>
    <html>
        <head>
            <title>ibuy Auctions</title>
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
                        <h2>Edit Auction</h2>
                    </div>
                    <div class="addAuction-form">
                        
                        <div class="form">
                            <form action="./operation/auction_operation.php" method="POST" autocomplete="off" enctype="multipart/form-data">
                                <input type="hidden" name="action" value="edit">
                                <input type="hidden" name="id" value="<?php echo $data['id'] ?>">
                                <div class="form-group">
                                    <label for="title" > Title : </label>
                                    <input type="text" name="title" id="title" value="<?php echo $data['title'] ?>" required>
                                </div>
                                <div class="form-group">
                                    
                                    <label for="description" > Description : </label>
                                    <!-- <textarea name="description" id="description" rows="4"> </textarea> -->
                                    <textarea id="description" name="description" rows="4" cols="50"><?php echo $data['description'] ?></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="category" >Category : </label>
                                    <select name="category" id="category" class="category">
                                    <?php
                                        $getCategoryDataSql = "SELECT * FROM `tbl_categories`";
                                        $getCategories = $conn->query($getCategoryDataSql);
                                        while ($data2 = $getCategories->fetch_assoc()) {
                                            if($data['category_id'] == $data2['id']){
                                                $selected = 'selected';
                                            }else{
                                                $selected = '';
                                            }
                                            echo '<option value="'.$data2['id'].'"'.$selected.'>'.$data2['category_name'].'</option>';
                                        }
                                    ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="endDate" > Auction End Date : </label>
                                    <input type="datetime-local" name="endDate" id="endDate" value="<?php echo $data['endDate'] ?>" required>
                                </div>
                                <div class="flex" style="display:flex; margin-top:0">
                                    <div class="form-group">
                                        <label for="image" > Product Photo : </label>
                                        <input type="file" name="image" id="image" accept="image/jpg, image/png , image/jpeg" >
                                    </div>
                                    <div class="form-group">
                                        <label for="price" > Price : </label>
                                        <input type="number" min="0" name="price" id="price" value="<?php echo (float)$data['price'] ?>" required>
                                    </div>
                                </div>
                                <div class="btn-group">
                                    <button class="btn btn-auction-submit" type="submit">Save</button>
                                </div>
                            </form>
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