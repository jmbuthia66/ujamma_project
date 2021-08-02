<?php
// used to connect to the database
$host = "localhost";
$db = "ujamaa";
$userdb = "root";
$pass = "";
  
try {
    $conn = new PDO("mysql:host={$host};dbname={$db}", $userdb, $pass);
}
  
// show error
catch(PDOException $exception){
    echo "Connection error: " . $exception->getMessage();
}
?>