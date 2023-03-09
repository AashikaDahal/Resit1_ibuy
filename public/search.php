<?php include("./dbConnection.php"); 
$text = $_GET['search'];
  $searchSql = "SELECT * FROM tbl_auctions WHERE (title LIKE '%$text' OR title LIKE '%$text%' OR title LIKE '$text%' OR  title = '$text') OR (description LIKE '%$text' OR description LIKE '%$text%' OR description LIKE '$text%' OR  description = '$text') ";
?>
<!DOCTYPE html>
<html>
  <head>
    <title>ibuy Auctions</title>
    <link rel="stylesheet" href="frontend.css" />
  </head>

  <body>
    <header>
        <section class="logo">
            <a href="./index.php">
                <h1>
                    <span class="i">i</span><span class="b">b</span><span class="u">u</span
                    ><span class="y">y</span>
                </h1>
            </a>
        </section>

      <form action="./search.php" method="GET">
        <input type="text" class="search" name="search" placeholder="Search for anything" />
        <input type="submit" class="search-btn" value="Search" />
      </form>
      <div class="login">
        <a href="./login.php">Login</a>
        <h1>/</h1>
        <a href="./register.php">Register</a>
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
    <img src="banners/1.jpg" alt="Banner" />

    <div class="page-position" style="margin:2rem">
        <h1>Search Page</h1>
    </div>
    <main>
      <!-- <h2>Latest Listings / Search Results / Category listing</h2> -->


      <ul class="productList">
        <?php
          $getSearchData = $conn->query($searchSql);
          while($data = $getSearchData->fetch_assoc()){


        ?>
        <li>
            <img src="./product.png" alt="Avatar" style="height:12rem;width:35rem;">
          <article>
            <h2><?php echo $data['title'] ?></h2>
            <h3>
                <?php
                    $getCategory = $conn->query("SELECT * FROM tbl_categories WHERE id = '{$data['category_id']}' limit 1");
                    $category = $getCategory->fetch_assoc();
                    echo $category['category_name']; 
                ?>
            </h3>
            <p> <?php echo $data['description'] ?>  </p>

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
