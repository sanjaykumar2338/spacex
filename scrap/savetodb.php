<?php
$servername = "test.ugly.a2hosted.com";
$username = "uglya_urlsuser";
$password = "e4ODa%qKhQ6N";
$dbname = "uglyahos_url";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$url = $_POST['url'];
$comment = $_POST['comment']; 
$sql = "INSERT INTO images (url, comment)
VALUES ('$url', '$comment')";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>