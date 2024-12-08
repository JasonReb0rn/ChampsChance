<?php

require_once 'dbh.inc.php';

// Query to retrieve posts
// Retrieves ALL posts, plus the associated username of the post, SORTED by date descending (newest at top)
$sql = "SELECT p.*, u.usersUid, u.usersAvatar, DATE_FORMAT(p.created_at, '%M %D %Y at %h:%i %p') AS formatted_created_at
        FROM posts p 
        JOIN users u ON p.author_id = u.usersId
        ORDER BY p.created_at DESC";
$result = $conn->query($sql);

// Quary to retrieve users

$posts = array();

if ($result->num_rows > 0) {
    // Fetch data from each row
    while ($row = $result->fetch_assoc()) {
        $posts[] = $row;
    }
}

// Close the connection
$conn->close();

// Output posts data as JSON
header('Content-Type: application/json');
echo json_encode($posts);
?>

