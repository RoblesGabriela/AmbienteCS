<?php
require_once 'config.php';

if($conn){
    echo "Connected successfully to the database.";
} else {
    echo "Failed to connect to the database. Error: " . mysqli_connect_error();
}
