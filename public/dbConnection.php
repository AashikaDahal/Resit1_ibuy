<?php 
    session_start();
  
//     // global $conn;
//    $servername = 'db';
//         $userName = 'root';
//         $password = 'root';
//         $dbName = 'assignment1';
 try {
//   $conn = new PDO("mysql:$dbName,$servername,$userName,$password);
  $conn = new PDO ('mysql:dbname=assignment1;host=db','root','root',[PDO::ATTR_ERRMODE =>PDO::ERRMODE_EXCEPTION]);
  // set the PDO error mode to exception
  
 } catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}
      

    function countPlus($table,$id) {
        $server = 'localhost';
        $userName = 'root';
        $password = '';
        $dbName = 'assignment1';

        $conn = new Mysqli($server,$userName,$password,$dbName);
        $increaseCountSql = "UPDATE `$table` SET tbl_used_count = tbl_used_count + 1 WHERE `id` = '$id'";
        $conn->query($increaseCountSql);
    }

    function countMinus($table,$id) {
        $server = 'localhost';
        $userName = 'root';
        $password = '';
        $dbName = 'assignment1';
        
$conn = new Mysqli($server,$userName,$password,$dbName);        
$increaseCountSql = "UPDATE `$table` SET tbl_used_count = tbl_used_count - 1 WHERE `id` = '$id'";
        $conn->query($increaseCountSql);
    }

    function checkCount($table,$id,$col) {
        $server = 'localhost';
        $userName = 'root';
        $password = '';
        $dbName = 'assignment1';
       
$conn = new Mysqli($server,$userName,$password,$dbName);
        $increaseCountSql = "SELECT * FROM `$table` WHERE `$col` = '$id'";
        $count = $conn->query($increaseCountSql);
        return $count->rowCount();
    }

    // countPlus('tbl_auctions','2');
?>