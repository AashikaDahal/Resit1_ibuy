<?php 
    include("./dbConnection.php");
    if($_SESSION['user_role'] != '' && ($_SESSION['user_role'] == 'admin' || $_SESSION['user_role'] == 'user')){
        if(isset($_SESSION['error_message'])){
            echo '<script> alert("'.$_SESSION['error_message'].'")</script>';
            unset($_SESSION['error_message']);
        }
        $photoLocation = "./public/images/auctions";
?>
<!DOCTYPE html>
<html>
	<head>
		<title>ibuy Auctions</title>
		<link rel="stylesheet" href="ibuy.css" />
	</head>

	<body>
        <section class="adminCategories-main">
            <section class="logo">
                    <a href="./index.php">
                        <h1>
                            <span class="i">i</span><span class="b">b</span><span class="u">u</span
                            ><span class="y">y</span>
                        </h1>
                    </a>
                </section>
            <div class="adminCategories-body">
                <div class="top">
                    <div class="add-category-btn">
                        <a href="./addAuction.php" class="btn btn-add-category"> + Add Auction</a>
                    </div>
                    <h2>Auctions Table</h2>
                    <div class="add-category-btn">
                        <a href="./adminDashboard.php"> <- Back </a>
                    </div> 
                </div>
                <div class="category-show-table">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>S.NO</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Category</th>
                                <th>Auction End Date</th>
                                <th>Price</th>
                                <th>Photo</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $i = 1;
                                if($_SESSION['user_role'] == 'admin'){
                                    $getUsersDataSql = "SELECT * FROM `tbl_auctions` ORDER BY id DESC";
                                }else{
                                    $getUsersDataSql = "SELECT * FROM `tbl_auctions` WHERE added_by = '{$_SESSION['user_email']}' ORDER BY id DESC";
                                }
                                $result = $conn->query($getUsersDataSql);
                                while($data = $result->fetch(PDO::FETCH_ASSOC)){
                            ?>
                            <tr>
                                <td><?php echo $i ?></td>
                                <td><?php echo $data['title'] ?></td>
                                <td><?php echo $data['description'] ?></td>
                                <td>
                                    <?php
                                        $getCategory = $conn->query("SELECT * FROM tbl_categories WHERE id = '{$data['category_id']}' limit 1");
                                        $category = $getCategory->fetch(PDO::FETCH_ASSOC);;
                                        echo $category['category_name']; 
                                    ?>
                                </td>
                                <td><?php echo $data['endDate'] ?></td>
                                <td><?php echo (float)$data['price'] ?></td>
                                <td><img src="./product.png" alt="auctionPhoto" style="height:5rem"></td>
                                <td >
                                    <div class="action-btn">
                                        <a href="./editAuction.php?id=<?php echo $data['id']?>" class="btn btn-edit">Edit</a> 
                                        <a href="./operation/auction_operation.php?action=delete&id=<?php echo $data['id']?>" class="btn btn-delete">Delete</a>
                                    </div>
                                </td>
                            </tr>
                            <?php
                                $i++;
                                }
                            ?>
                        </tbody>
                        
                    </table>
                </div>
            </div>
        </section>
    </body>
</html>
<?php }else{
    // header("Location: ./login.php");
    echo '<script>window.location.href="login.php"</script>';

}
?>