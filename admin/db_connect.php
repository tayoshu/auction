<?php 

$conn = new mysqli('localhost', 'root', '', 'bidding_db');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}