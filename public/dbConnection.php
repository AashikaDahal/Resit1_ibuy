<?php 
    session_start();
  
    // global $conn;
   $servername = 'localhost';
        $userName = 'root';
        $password = '';
        $dbName = 'ibuy';
   try {
  $conn = new Mysqli($servername,$userName,$password,$dbName);
  // set the PDO error mode to exception
  
} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}
      

    function countPlus($table,$id) {
        $server = 'localhost';
        $userName = 'root';
        $password = '';
        $dbName = 'ibuy';
//      $conn = new PDO("mysql:host=$servername;dbname=$dbName", $userName, $password);
//  set the PDO error mode to exception
//   $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $conn = new Mysqli($server,$userName,$password,$dbName);
        $increaseCountSql = "UPDATE `$table` SET tbl_used_count = tbl_used_count + 1 WHERE `id` = '$id'";
        $conn->query($increaseCountSql);
    }

    function countMinus($table,$id) {
        $server = 'localhost';
        $userName = 'root';
        $password = '';
        $dbName = 'ibuy';
        // $conn = new PDO("mysql:host=$servername;dbname=$dbName", $userName, $password);
  // set the PDO error mode to exception
//   $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$conn = new Mysqli($server,$userName,$password,$dbName);        
$increaseCountSql = "UPDATE `$table` SET tbl_used_count = tbl_used_count - 1 WHERE `id` = '$id'";
        $conn->query($increaseCountSql);
    }

    function checkCount($table,$id,$col) {
        $server = 'localhost';
        $userName = 'root';
        $password = '';
        $dbName = 'ibuy';
        // $conn = new PDO("mysql:host=$servername;dbname=$dbName", $userName, $password);
  // set the PDO error mode to exception
//   $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$conn = new Mysqli($server,$userName,$password,$dbName);
        $increaseCountSql = "SELECT * FROM `$table` WHERE `$col` = '$id'";
        $count = $conn->query($increaseCountSql);
        return $count->num_rows;
    }

    // countPlus('tbl_auctions','2');
?>