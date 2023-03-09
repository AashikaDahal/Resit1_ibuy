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
		<title>ibuy Admin Categories</title>
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
                        <a href="./addCategory.php" class="btn btn-add-category"> + Add Category</a>
                    </div>
                    <h2>Categories Table</h2>
                    <div class="add-category-btn">
                        <a href="./adminDashboard.php"> <- Back </a>
                    </div> 
                </div>
                <div class="category-show-table">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>S.NO</th>
                                <th>Category</th>
                                <th>Total Items</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $i = 1;
                                $getUsersDataSql = "SELECT * FROM `tbl_categories` ORDER BY id DESC";
                                $result = $conn->query($getUsersDataSql);
                                while($data = $result->fetch_assoc()){
                            ?>
                            <tr>
                                <td><?php echo $i ?></td>
                                <td><?php echo $data['category_name'] ?></td>
                                <td>
                                    <?php 
                                        $count = checkCount("tbl_auctions",$data['id'],'category_id'); 
                                        echo $count;
                                    ?>
                                </td>
                                <td class="action-btn">
                                    <a href="./editCategory.php?id=<?php echo $data['id']?>" class="btn btn-edit">Edit</a> 
                                    <a href="./operation/categories_operation.php?action=delete&id=<?php echo $data['id']?>" class="btn btn-delete">Delete</a>
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
    header("Location: ./login.php");
}
?>