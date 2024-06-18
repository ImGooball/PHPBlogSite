<?php
session_start();
// Database connection
$servername = "localhost:3307";
$username = "root";
$password = "";
$dbname = "gooball_db";

$conn = new mysqli($servername, $username, $password, $dbname);

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
        <div class="header text-center my-4">
            <h1>Personal Blog</h1>
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="admin.php" class="btn">Add New Post</a>
                <a href="logout.php" class="btn">Logout</a>
            <?php else: ?>
                <a href="login.php" class="btn">Login</a>
                <a href="register.php" class="btn">Register</a>
            <?php endif; ?>
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
                    echo "<a href='post.php?id=" . $row['id'] . "' class='btn'>Read More</a>";
                    echo "</div>";
                }
            } else {
                echo "<p class='text-center'>No posts available.</p>";
            }
            $conn->close();
            ?>
        </div>
    </div>
</body>
</html>
