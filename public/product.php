<?php 
    include("./dbConnection.php"); 
    if(isset($_SESSION['error_message'])){
        echo '<script> alert("'.$_SESSION['error_message'].'")</script>';
        unset($_SESSION['error_message']);
    }
    $id = $_GET['id'];
    $getAuctionDataSql = "SELECT * FROM `tbl_auctions` WHERE `id` = '$id'";
    // echo $getAuctionDataSql;
    $getAuctionData = $conn->query($getAuctionDataSql);
    $data = $getAuctionData->fetch_assoc();

   
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
          while($data1 = $result->fetch_assoc()){
        ?>
        <li><a class="categoryLink" href="./categories.php?id=<?php echo $data1['id'] ?>"><?php echo $data1['category_name'] ?></a></li>
        <?php } ?>
        <li><a class="categoryLink" href="javascript:void(0)" onclick="slideData()">More</a></li>
      </ul>
    </nav>
    <!-- <img src="banners/1.jpg" alt="Banner" /> -->
    <div class="page-position" style="margin:2rem">
        <h1>Product Page</h1>
    </div>
    <main>
      <article class="product">
        <img src="./product.png" alt="product name" style="height:22rem;width:28rem;" />
        <section class="details">
          <h2><?php echo $data['title'] ?></h2>
          <h3>
            <?php
                $getCategory = $conn->query("SELECT * FROM tbl_categories WHERE id = '{$data['category_id']}' limit 1");
                $category = $getCategory->fetch_assoc();
                echo $category['category_name']; 
            ?>
          </h3>
          <p>Auction created by 
            <a href="javascript:void(0)">
                <?php
                    $getCategory = $conn->query("SELECT * FROM tbl_users WHERE email = '{$data['added_by']}' limit 1");
                    $category = $getCategory->fetch_assoc();
                    echo $category['fullname']; 
                ?>
            </a>
            </p>
          <p class="price">Current Highest bid: £ <?php
                $getMyBidSql = "SELECT * FROM tbl_bids WHERE product_id = '{$data['id']}' ORDER BY price DESC LIMIT 1";
                $getMyBidData = $conn->query($getMyBidSql);
                if($getMyBidData->num_rows > 0){
                    while($row = $getMyBidData->fetch_assoc()){
                        echo (float)$row['price'];
                    }
                }else{
                    echo (float)$data['price'];
                }
            ?></p>
          <p class="my-bid">
            <?php
              if(isset($_SESSION['user_id'])){
                $getMyBidSql = "SELECT * FROM tbl_bids WHERE user_id = '{$_SESSION['user_id']}' AND product_id = '{$data['id']}' ORDER BY price DESC LIMIT 1";
                $getMyBidData = $conn->query($getMyBidSql);
                while($row = $getMyBidData->fetch_assoc()){
                    echo 'My bid: £'.(float)$row['price'].'&emsp; <a href="./operation/bid_operation.php?action=delete&id='.$row['id'].'" style="color:red;">Delete Bid</a>';
                }
              }
            ?>
          </p>
          <time>Time left: <?php echo $data['endDate'] ?></time>
          <form action="./operation/bid_operation.php" method="POST" class="bid">
            <input type="hidden" name="action" value="add"/>
            <input type="hidden" name="id" value="<?php echo $data['id'] ?>"/>
            <input type="text" class="bit-price" name="bid" placeholder="Enter bid amount" />
            <input type="submit" class="bit-btn" value="Place bid" />
          </form>
        </section>
        <section class="description">
          <p>
            <?php echo $data['description']  ?>  
          </p>
        </section>

        <section class="reviews">
          <h2>All Reviews Of <?php echo $data['title'] ?></h2>
          <ul>
          <?php
                $getMyReviewSql = "SELECT * FROM tbl_review WHERE product_id = '{$data['id']}'";
                $getMyReviewData = $conn->query($getMyReviewSql);
                while($row1 = $getMyReviewData->fetch_assoc()){
                    $getUserSql="SELECT * FROM tbl_users WHERE id ='{$row1['user_id']}'";
                    $getUserData = $conn->query($getUserSql);
                    $user = $getUserData->fetch_assoc();
                    echo '<li><strong> '.$user['fullname'].' </strong> &emsp;'.$row1['review'].' <em>'.$row1['added_on'].' </em>&emsp;';
                    if(($_SESSION['user_id'] != '') && $_SESSION['user_id'] == $row1['user_id']) {
                        echo '<a href="./operation/review_operation.php?action=delete&id='.$row1['id'].'" style="color:red;">Delete Review</a></li>';
                    }
                }
            ?>
          </ul>

          <form action="./operation/review_operation.php" method="POST" class="bid">
            <h3>Add your review</h3>
            <input type="hidden" name="action" value="add"/>
            <input type="hidden" name="id" value="<?php echo $data['id'] ?>"/>
            <textarea name="review-text" rows="7"></textarea>

            <input type="submit" class="submit-me" name="submit" value="Add Review" />
          </form>
        </section>
      </article>
      
      <footer>&copy; ibuy <?php echo date('Y') ?></footer>
    </main>
  </body>
</html>