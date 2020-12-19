<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

include_once 'config.php';

$id = (int)$_GET['id'];


mysqli_query($link,"DELETE short_links , users_links FROM short_links INNER JOIN users_links ON short_links.id=users_links.short_links_id WHERE short_links.id='".$id."'");

header("Location: welcome.php");
?> 