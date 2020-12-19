<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
include_once 'config.php';
mysqli_query($link,"DELETE FROM short_links WHERE id = ANY (Select id From short_links WHERE short_links.id NOT IN (SELECT users_links.short_links_id FROM users_links ))  AND short_links.date_time < NOW() - INTERVAL 30 DAY");
header("Location: url_list.php");

?>
