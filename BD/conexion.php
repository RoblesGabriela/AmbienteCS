<?php


$servername = "localhost";
$username = "root";
$password = "";
$database = "cstore";

$conn = new mysqli($servername, $username, $password, $database);

if($conn->connect_error){
    die("Conexio fallida");
} 

