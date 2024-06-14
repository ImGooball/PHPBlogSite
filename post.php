<?php
// Database connection
$servername = "localhost:3307";
$username = "root";
$password = "";
$dbname = "gooball_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Post</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <div class="container">
        <?php
        // Fetch post by ID
        $id = $_GET['id'];
        $sql = "SELECT * FROM posts WHERE id = $id";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            echo "<h1>" . $row['title'] . "</h1>";
            echo "<p class='timestamp'>" . $row['created_at'] . "</p>";
            echo "<p>" . nl2br(htmlspecialchars($row['content'])) . "</p>";
            echo "<a href='index.php' class='btn'>Back to Home</a>";
            echo "<a href='edit_post.php?id=" . $row['id'] . "' class='btn'>Edit Post</a>";
            echo "<a href='delete_post.php?id=" . $row['id'] . "' class='btn btn-delete'>Delete Post</a>";
        } else {
            echo "Post not found.";
        }
        $conn->close();
        ?>
    </div>
</body>
</html>
