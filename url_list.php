<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>

<html>
<head>
    <title>URL List</title>
    <!-- Bootstrap CDN -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <style type="text/css">
        body{ font: 14px sans-serif; text-align: center; }
    </style>
</head>
<body>
<div class="page-header">
        <h1>Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. List of all Short links. 20 per page</h1>
    </div>
    <p>
        <a href="welcome.php" class="btn btn-primary">Home</a>
        <a href="index.php" class="btn btn-primary">Create Short Link</a>
        <a href="reset-password.php" class="btn btn-warning">Reset Your Password</a>
        <a href="logout.php" class="btn btn-danger">Sign Out of Your Account</a>
        <a href="url_list.php" class="btn btn-primary">All short Urls</a>
        <a href="delete-30days-old.php" class="btn btn-primary">Delete 30 days old and with no user</a>
    </p>
    <?php
include 'db_connection.php';
        if (isset($_GET['pageno'])) {
            $pageno = $_GET['pageno'];
        } else {
            $pageno = 1;
        }
        $no_of_records_per_page = 20;
        $offset = ($pageno-1) * $no_of_records_per_page;

        $conn = OpenCon();

        $total_pages_sql = "SELECT COUNT(*) FROM short_links";
        $result = mysqli_query($conn,$total_pages_sql);
        $total_rows = mysqli_fetch_array($result)[0];
        $total_pages = ceil($total_rows / $no_of_records_per_page);

        $sql = "SELECT * FROM short_links LIMIT $offset, $no_of_records_per_page";
        $res_data = mysqli_query($conn,$sql);
        echo '<table class="table table-striped table-bordered table-hover">'; 
            echo"<TR><TD>Id</TD><TD>URL</TD><TD>Short Code</TD><TD>Hits</TD></TR>"; 
        while($row = mysqli_fetch_array($res_data)){
            
            echo "<tr><td>"; 
            echo $row['id'];
            echo "</td><td>";
            echo $row['url'];
            echo "</td><td>";   
            echo $row['short_code'];
            echo "</td><td>";    
            echo $row['hits'];
            echo "</TD></tr>";  
            
            
        }echo "</table>"; 
        CloseCon($conn);
    ?>
    <ul class="pagination">
        <li><a href="?pageno=1">First</a></li>
        <li class="<?php if($pageno <= 1){ echo 'disabled'; } ?>">
            <a href="<?php if($pageno <= 1){ echo '#'; } else { echo "?pageno=".($pageno - 1); } ?>">Prev</a>
        </li>
        <li class="<?php if($pageno >= $total_pages){ echo 'disabled'; } ?>">
            <a href="<?php if($pageno >= $total_pages){ echo '#'; } else { echo "?pageno=".($pageno + 1); } ?>">Next</a>
        </li>
        <li><a href="?pageno=<?php echo $total_pages; ?>">Last</a></li>
    </ul>
</body>
</html>