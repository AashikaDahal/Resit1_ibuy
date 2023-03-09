<?php include("./dbConnection.php"); 
  // $_SESSION['user_id'] ='';
?>
<!DOCTYPE html>
<html>
  <head>
    <title>ibuy Auctions</title>
    <link rel="stylesheet" href="frontend.css" />
  </head>

  <body>
  <header>
      <a href="./index.php">
        <h1>
            <span class="i">i</span><span class="b">b</span><span class="u">u</span
            ><span class="y">y</span>
        </h1>
      </a>

      <form action="search.php" method="GET">
        <input type="text" class="search" name="search" placeholder="Search for anything" />
        <input type="submit" class="search-btn" value="Search" />
      </form>
      <div class="login">
      <?php
            if(isset($_SESSION['user_id']) && $_SESSION['user_id'] != ''){
        ?>
            <a href="./adminDashboard.php">Dashboard</a>
            <?php
            }else{
              ?>
              <a href="./login.php">Login</a>
              <h1>/</h1>
              <a href="./register.php">Register</a>
                <?php
            }
        ?>
      </div>
    </header>
    <div class="line"></div>

    <nav>
      <ul>
        <?php 
          $getUsersDataSql ="SELECT * FROM `tbl_categories` ORDER BY id ASC";
          $result = $conn->query($getUsersDataSql);
          // if($result){
            while($data = $result->fetch_assoc()){
         
        ?>
        <li><a class="categoryLink" href="./categories.php?id=<?php echo $data['id'] ?>"><?php echo $data['category_name'] ?></a></li>
        <?php } ?>
        <li><a class="categoryLink" href="javascript:void(0)" onclick="slideData()">More</a></li>
      </ul>
    </nav>
    <img src="banners/1.jpg" alt="Banner" />
 
    <div class="page-position" style="margin:2rem">
        <h1>All Product Page</h1>
    </div>

    <main>
      <div class="all-data">
      <?php
      $getUsersDataSql = "SELECT * FROM `tbl_auctions` ORDER BY id DESC";
      $result = $conn->query($getUsersDataSql);
      while($data = $result->fetch_assoc()){
      ?>
        <a href="./product.php?id=<?php echo $data['id'] ?>">
          <div class="card">
            <img src="./product.png" alt="Avatar" style="height:15rem;width:100%">
            <div class="container">
              <h3><b><?php echo $data['title'] ?></b></h3> 
              <div class="category-cost">
                <p>
                    <?php
                      $getCategory = $conn->query("SELECT * FROM tbl_categories WHERE id = '{$data['category_id']}' limit 1");
                      $category = $getCategory->fetch_assoc();
                      echo $category['category_name']; 
                    ?>
                </p> 
                <p>
                <?php echo '£'. $data['price'] ?>
                </p>
              </div>
            </div>
          </div>
        </a>
        <?php
        //  }
      }
      ?>
      </div>
      <footer>&copy; ibuy <?php echo date('Y') ?></footer>
    </main>
  </body>
</html>
