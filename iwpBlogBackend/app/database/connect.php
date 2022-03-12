<?php

$host = 'localhost';
$user = 'root';
$pass = 'soulreaper';
$db_name = 'iwpBlog';

$conn = new MySQLi($host,$user,$pass,$db_name);

if($conn->connect_error){
    die("Database connection error: " . $conn->connect_error);
}