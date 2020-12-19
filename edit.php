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
global $row;
$row = mysqli_fetch_array(mysqli_query($link, "Select * FROM short_links WHERE id='".$id."'"));
//print_r($row);
//mysqli_query($link,"DELETE short_links , users_links FROM short_links INNER JOIN users_links ON short_links.id=users_links.short_links_id WHERE short_links.id='".$id."'");

//header("Location: welcome.php");
?> 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit URL DATA</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; text-align: center; }
        .wrapper{ width: 350px; padding: 20px; }
    </style>
</head>
<body>
<div class="page-header">
        <h1>Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Welcome to our site.</h1>
    </div>
    <p>
        <a href="welcome.php" class="btn btn-primary">Home</a>
        <a href="index.php" class="btn btn-primary">Create Short Link</a>
        <a href="reset-password.php" class="btn btn-warning">Reset Your Password</a>
        <a href="logout.php" class="btn btn-danger">Sign Out of Your Account</a>
        <a href="url_list.php" class="btn btn-primary">All short Urls</a>
    </p>

    <p style ="padding-top:50px;"> Current URL : <?php echo $row['url'];?></P>
    <form name="form" action="" method="post">
    <p><input style="width: 500px; height: 22px;" type="url" name="url" placeholder="Enter new url" required /></p>
    <p><input class="button" type="submit" /></p>
</form>


</body>
</html>
<?php 
if(isset($_POST['url']) && $_POST['url']!=""){ 
    $url = urldecode($_POST['url']);
    if(filter_var($url, FILTER_VALIDATE_URL)){

        $sql = "UPDATE short_links SET short_links.url = '".$url."' WHERE short_links.id = '".$row['id']."'";
        mysqli_query($link,$sql);
        header("Location: welcome.php");
    }
}

?>