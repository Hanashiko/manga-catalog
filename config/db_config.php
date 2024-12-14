<?php
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'php');  
define('DB_PASSWORD', 'mAp101HG');      
define('DB_DATABASE', 'manga_catalog');

$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
