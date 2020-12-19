<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; text-align: center; }
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
    <h2> Following are your short links.</h2>
    <?php 
        // Include config file
        require_once "config.php";
        $sql ="SELECT short_links.* FROM short_links JOIN users_links ON short_links.id=users_links.short_links_id where users_links.userId= '".$_SESSION["id"]."'";
        $result = mysqli_query($link, $sql);
        echo '<table class="table table-striped table-bordered table-hover">'; 
            echo"<TR><TD>Edit/Delete</TD><TD>URL</TD><TD>Short Code</TD><TD>Hits</TD></TR>"; 
        while($row = mysqli_fetch_array($result)){
            
            echo "<tr><td>"; 
            echo "<a href=\"delete.php?id=".$row['id']."\">Delete</a>";
            echo " / ";
            echo "<a href=\"edit.php?id=".$row['id']."\">Edit</a>";
            echo "</td><td>";
            echo $row['url'];
            echo "</td><td>";   
            echo $row['short_code'];
            echo "</td><td>";    
            echo $row['hits'];
            echo "</TD></tr>";  
            
            
        }echo "</table>"; 
    ?>
</body>
</html>