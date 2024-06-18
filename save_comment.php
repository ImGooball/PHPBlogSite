<?php
session_start();
// Database connection
$servername = "localhost:3307";
$username = "root";
$password = "";
$dbname = "gooball_db";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $content = $_POST['content'];
    $post_id = $_POST['post_id'];
    $user_id = $_SESSION['user_id'];

    $sql = "INSERT INTO comments (post_id, user_id, content) VALUES ('$post_id', '$user_id', '$content')";
    if ($conn->query($sql) === TRUE) {
        header("Location: post.php?id=$post_id");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>
