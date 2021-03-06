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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>URL Shortener</title>
    
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
    <h1> Paste your url here, We will make it short :) </h1>
    <form name="form" action="" method="get">
    <p><input style="width: 500px; height: 22px; margin-top: 60px;" type="url" name="url" required /></p>
    <p><input class="button" type="submit" /></p>
</form>
<?php
include 'db_connection.php';
$base_url = "localhost/folo/folo-php-mysql";

if(isset($_GET['url']) && $_GET['url']!=""){ 
    $url = urldecode($_GET['url']);
    if(filter_var($url, FILTER_VALIDATE_URL)){
        //create connection
        $conn = OpenCon();
        $slug = getShortUrl($url);
        echo "Your short url: ";echo "<b>";echo $base_url; echo"/"; echo $slug;echo "</b>";
        Closecon($conn);
    }
}


//function generate code
function generateCOde(){
    GLOBAl $conn;
    $token = substr(md5(uniqid(rand(),true)),0,3);
    $query = "SELECT * FROM short_links WHERE short_code = '".$token."'";
    $result = $conn->query($query);
    if($result->num_rows >0){
        generateCode();
    }else{
        return $token;
    }
}
// getshorturl function 
function getShortUrl($url){
    global $conn;
    $query = "SELECT * FROM short_links WHERE url = '".$url."'";
    $result = $conn->query($query);
    if($result->num_rows > 0){
        $row = $result->fetch_assoc();
        return $row["short_code"];
    }else {
        $short_code = generateCode();
        $sql = "INSERT INTO short_links (url, short_code) VALUES ('".$url."','".$short_code."')";
        if($conn->query($sql)==TRUE){
            $sql = "INSERT INTO users_links (userId, short_links_id) VALUES ('".$_SESSION["id"]."','".$conn->insert_id."')";
            $conn->query($sql);
            return $short_code;
        }else{
            die("unknown error occured");

            }
        }
    }

if(isset($_GET['redirect']) && $_GET['redirect']!= ""){
    $slug = urldecode($_GET['redirect']);
    $conn = OpenCon();
    $url = GetRedirectUrl($slug);
    CloseCon($conn);
    header("location:$url");
    exit;
}   

function GetRedirectUrl($slug){
    global $conn;
    $query = "SELECT * FROM short_links WHERE short_code = '".addslashes($slug)."'";
    $result = $conn->query($query);
    if ($result->num_rows > 0){
        $row = $result->fetch_assoc();
        // increase the hit in DB
        $hits=$row['hits']+1;
        $sql = "update short_links set hits='".$hits."' where id='".$row['id']."' ";
        $conn->query($sql);
        return $row['url'];
    }else{
        die("Invalid link");
    }
    
}

?>
</body>
</html>