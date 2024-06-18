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
            if (isset($_SESSION['user_id'])) {
                echo "<a href='edit_post.php?id=" . $row['id'] . "' class='btn'>Edit Post</a>";
                echo "<a href='delete_post.php?id=" . $row['id'] . "' class='btn btn-delete'>Delete Post</a>";
            }

            // Fetch post comments
            $comments_sql = "SELECT c.content, c.created_at, u.username FROM comments c JOIN users u ON c.user_id = u.id WHERE c.post_id = $id ORDER BY c.created_at DESC";
            $comments_result = $conn->query($comments_sql);

            if ($comments_result->num_rows > 0) {
                echo "<div class='comments'>";
                echo "<h3>Comments:</h3>";
                while ($comment = $comments_result->fetch_assoc()) {
                    echo "<div class='comment'>";
                    echo "<p><strong>" . $comment['username'] . "</strong> (" . $comment['created_at'] . "):</p>";
                    echo "<p>" . nl2br(htmlspecialchars($comment['content'])) . "</p>";
                    echo "</div>";
                }
                echo "</div>";
            } else {
                echo "<p>No comments yet.</p>";
            }

            if (isset($_SESSION['user_id'])) {
                echo "<form method='post' action='save_comment.php'>";
                echo "<textarea name='content' required></textarea>";
                echo "<input type='hidden' name='post_id' value='$id'>";
                echo "<input type='submit' value='Add Comment' class='btn'>";
                echo "</form>";
            } else {
                echo "<p><a href='login.php'>Log in</a> to add a comment.</p>";
            }
        } else {
            echo "Post not found.";
        }
        $conn->close();
        ?>
    </div>
</body>
</html>
