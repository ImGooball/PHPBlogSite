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
                <a href="admin.php" class="btn btn-primary">Add New Post</a>
                <a href="logout.php" class="btn btn-secondary">Logout</a>
            <?php else: ?>
                <a href="login.php" class="btn btn-primary">Login</a>
                <a href="register.php" class="btn btn-secondary">Register</a>
            <?php endif; ?>
        </div>
        <div class="posts">
            <?php
            // Fetch posts
            $sql = "SELECT * FROM posts ORDER BY created_at DESC";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<div class='post card mb-4'>";
                    echo "<div class='card-body'>";
                    echo "<h2 class='card-title'>" . $row['title'] . "</h2>";
                    echo "<p class='card-text'>" . substr($row['content'], 0, 200) . "...</p>";
                    echo "<a href='post.php?id=" . $row['id'] . "' class='btn btn-primary'>Read More</a>";
                    echo "</div>";
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
