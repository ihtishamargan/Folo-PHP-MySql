<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>URL Shortener</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1> Paste your url here, We will make it short :) </h1>
    <form name="form" action="" method="post">
    <p><input style="width: 500px; height: 22px;" type="url" name="url" required /></p>
    <p><input class="button" type="submit" /></p>
</form>
<?php
include 'db_connection.php';
$base_url = "localhost/folo tasks/folo-php-mysql";
// getshorturl function 
function getShortUrl($url){
    $conn = openCon($url);
    $query = "SELECT * FROM short_links WHERE url = '".$url."'";
    $result = $conn->query($query);
    if($result->num_rows > 0){
        $row = $result->fetch_assoc();
        return $row->['short_code'];
    }else {
        $short_code = generateCode();
        $sql = "INSERT INTO short_links (url, short_code) VALUES ('".$url."','".$short_code."')";
        if($conn->query($sql)==TRUE){
            return $short_code;
        }else{
            die("unknown error occured");

            }
        }
    }
}
if(isset($_POST['url']) && $_POST['url']!=""){ 
    $url = urldecode($_POST['url']);
    if(filter_var($url, FILTER_VALIDATE_URL)){
        //create connection
        $slug = getShortUrl($url);
        echo 'Here is the short <a href="'; echo $base_url; echo"/"; echo $slug;
    }
}

?>
</body>
</html>