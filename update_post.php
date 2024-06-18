<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
// Database connection
$servername = "localhost:3307";
$username = "root";
$password = "";
$dbname = "gooball_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = $_POST['id'];
$title = $_POST['title'];
$content = $_POST['content'];
$user_id = $_SESSION['user_id'];

$sql = "UPDATE posts SET title='$title', content='$content', user_id='$user_id' WHERE id=$id";

if ($conn->query($sql) === TRUE) {
    header("Location: post.php?id=$id");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
