<?php 
    include("./dbConnection.php");
    if($_SESSION['user_role'] != '' && $_SESSION['user_role'] == 'admin'){
        if(isset($_SESSION['error_message'])){
            echo '<script> alert("'.$_SESSION['error_message'].'")</script>';
            unset($_SESSION['error_message']);
        }
?>
<!DOCTYPE html>
    <html>
        <head>
            <title>ibuy Add Categories</title>
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
                        <h2>Add Categories</h2>
                        <a href="./adminCategories.php"> <- Back </a>
                    </div>
                    <div class="addAuction-form">
                        <input type="hidden" name="action" value="add">
                        <div class="form">
                            <form action="./operation/categories_operation.php" method="POST" autocomplete="off">
                                <input type="hidden" name="action" value="add">
                                <div class="form-group">
                                    <label for="category_name" > Category Name : </label>
                                    <input type="text" name="category_name" id="category_name" required>
                                </div>
                                <div class="btn-group">
                                    <button class="btn btn-auction-submit" type="submit">Add Category</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    
                </div>
            </section>
        </body>
    </html>
    <?php }else{
    header("Location: ./login.php");
}
?>