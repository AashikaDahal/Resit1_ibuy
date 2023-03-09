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
                        <a href="./addAdmin.php" class="btn btn-add-category"> + Add Admin</a>
                    </div>
                    <div class="add-category-btn">
                        <a href="./adminDashboard.php"> <- Back </a>
                    </div>
                </div>
                <div class="category-show-table">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>S.NO</th>
                                <th>Users</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $i = 1;
                                $getUsersDataSql = "SELECT * FROM `tbl_users`";
                                $result = $conn->query($getUsersDataSql);
                                while($data = $result->fetch_assoc()){
                            ?>
                            <tr>
                                <td><?php echo $i ?></td>
                                <td><?php echo $data['fullname'] ?></td>
                                <td><?php echo $data['email'] ?></td>
                                <td><?php echo $data['role'] ?></td>
                                <td class="action-btn">
                                    <a href="./editAdmin.php?id=<?php echo $data['id']?>" class="btn btn-edit">Edit</a> 
                                    <a href="javascript:void(0)" onclick="checkConfirm('<?php echo $data['id'] ?>')" class="btn btn-delete">Delete</a>
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
        <script>
            function checkConfirm(id) {
                if(id == <?php echo $_SESSION['user_id']?>){
                    text = "You are deleting your own account, Are you sure to delete?";
                }else{
                    text = "Are you sure to delete?";
                }
                if(confirm(text) == true){
                    window.location.href = "./operation/login_register_operation.php?action=delete&id="+id;
                }
            }
        </script>
    </body>
</html>
<?php }else{
    header("Location: ./login.php");
}
?>
