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
    <title>Personal Blog</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Personal Blog</h1>
            <a href="admin.php" class="btn">Add New Post</a>
        </div>
        <div class="posts">
            <?php
            // Fetch posts
            $sql = "SELECT * FROM posts ORDER BY created_at DESC";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<div class='post'>";
                    echo "<h2>" . $row['title'] . "</h2>";
                    echo "<p class='timestamp'>" . $row['created_at'] . "</p>";
                    echo "<p>" . substr($row['content'], 0, 200) . "...</p>";
                    echo "<a href='post.php?id=" . $row['id'] . "'>Read More</a>";
                    echo "</div>";
                }
            } else {
                echo "No posts available.";
            }
            $conn->close();
            ?>
        </div>
    </div>
</body>
</html>
