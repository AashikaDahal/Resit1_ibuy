<?php 
    include("./dbConnection.php"); 
    if(isset($_SESSION['error_message'])){
        echo '<script> alert("'.$_SESSION['error_message'].'")</script>';
        unset($_SESSION['error_message']);
    }
    $id=$_GET['id'];
    
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

      <form action="./search.php" method="GET">
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
          $getUsersDataSql = "SELECT * FROM `tbl_categories` ORDER BY id ASC";
          $result = $conn->query($getUsersDataSql);
          while($data = $result->fetch(PDO::FETCH_ASSOC)){
        ?>
        <li><a class="categoryLink" href="./categories.php?id=<?php echo $data['id'] ?>"><?php echo $data['category_name'] ?></a></li>
        <?php } ?>
        <li><a class="categoryLink" href="javascript:void(0)" onclick="slideData()">More</a></li>
      </ul>
    </nav>
    <!-- <img src="banners/1.jpg" alt="Banner" /> -->
    <h2 style="margin:1rem; margin-top:2rem;margin-left:3rem">
      <?php
          $getCategoryTitleSql = "SELECT * FROM `tbl_categories` WHERE id = '$id'";
          $result = $conn->query($getCategoryTitleSql);
          $title = $result->fetch(PDO::FETCH_ASSOC);;
          echo $title['category_name'];
      ?>
    </h2>
    <main>


      <ul class="productList">
      <?php
        $getCategoriesDataSql = "SELECT * FROM `tbl_auctions` WHERE category_id = '$id'";
        $result = $conn->query($getCategoriesDataSql);
        while($data = $result->fetch(PDO::FETCH_ASSOC)){
      ?>
        <li>
            <img src="./product.png" alt="Avatar" style="height:12rem;width:35rem;">
          <article>
            <h2><?php echo $data['title'] ?></h2>
            <h3>
                <?php
                    $getCategory = $conn->query("SELECT * FROM tbl_categories WHERE id = '{$data['category_id']}' limit 1");
                    $category = $getCategory->fetch(PDO::FETCH_ASSOC);;
                    echo $category['category_name']; 
                ?>
            </h3>
            <p> <?php echo $data['description'] ?>  </p>

            <p class="price">Current Highest bid: £ <?php
                $getMyBidSql = "SELECT * FROM tbl_bids WHERE product_id = '{$data['id']}' ORDER BY price DESC LIMIT 1";
                $getMyBidData = $conn->query($getMyBidSql);
                if($getMyBidData->rowCount() > 0){
                    while($row = $getMyBidData->fetch(PDO::FETCH_ASSOC)){
                        echo (float)$row['price'];
                    }
                }else{
                    echo (float)$data['price'];
                }
            ?></p>
            <a href="./product.php?id=<?php echo $data['id'] ?>" class="more auctionLink"
              >More &gt;&gt;</a
            >
          </article>
        </li>
        <?php
        }
        ?>
      </ul>

      <hr />
        
      <footer>&copy; ibuy <?php echo date('Y') ?></footer>
    </main>
  </body>
</html>
