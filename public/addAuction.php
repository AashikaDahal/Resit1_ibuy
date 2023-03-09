<?php 
    include("./dbConnection.php");
    if($_SESSION['user_role'] != '' && ($_SESSION['user_role'] == 'admin' || $_SESSION['user_role'] == 'user')){
        // echo "<pre>";
        // var_dump($_SESSION);
        // echo "</pre>";
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
                    <div class="addAuction-form">
                        <div class="top">
                            <h2>Add Auction</h2>
                            <a href="./manageAuction.php"> <-- Back</a>
                        </div>
                        <div class="form">
                            <form action="./operation/auction_operation.php" method="POST" autocomplete="off" enctype="multipart/form-data">
                                <input type="hidden" name="action" value="add">
                                <div class="form-group">
                                    <label for="title" > Title : </label>
                                    <input type="text" name="title" id="title" required>
                                </div>
                                <div class="form-group">
                                    
                                    <label for="description" > Description : </label>
                                    <!-- <textarea name="description" id="description" rows="4"> </textarea> -->
                                    <textarea id="description" name="description" rows="4" cols="50" style="padding:0.5rem"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="category" >Category : </label>
                                    <select name="category" id="category" class="category">
                                    <?php
                                        $getCategoryDataSql = "SELECT * FROM `tbl_categories`";
                                        $getCategories = $conn->query($getCategoryDataSql);
                                        while ($data = $getCategories->fetch_assoc()) {
                                            echo '<option value="'.$data['id'].'">'.$data['category_name'].'</option>';
                                        }
                                    ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="endDate" > Auction End Date : </label>
                                    <input type="datetime-local" name="endDate" id="endDate" required>
                                </div>
                                <div class="flex" style="display:flex; margin-top:0">
                                    <div class="form-group">
                                        <label for="image" > Product Photo : </label>
                                        <input type="file" name="image" id="image" accept="image/jpg, image/png , image/jpeg" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="price" > Price : </label>
                                        <input type="number" min="0" name="price" id="price" required>
                                    </div>
                                </div>
                                <div class="btn-group">
                                    <button class="btn btn-auction-submit" type="submit">Add Auction</button>
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