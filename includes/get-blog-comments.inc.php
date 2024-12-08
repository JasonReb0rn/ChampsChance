<?php

require_once 'dbh.inc.php';

// Retrieve the value of the 'postid' parameter from the URL
$postid = isset($_GET['postid']) ? $_GET['postid'] : null;

// Query to retrieve comments for a specific post
// Retrieves ALL comments for the specified post, plus the associated username of the commenter, SORTED by date descending (newest at top)
$sql = "SELECT c.*, u.usersUid, u.usersAvatar, DATE_FORMAT(c.created_at, '%M %D %Y at %h:%i %p') AS formatted_created_at 
        FROM comments c 
        JOIN users u ON c.user_id = u.usersId
        WHERE c.post_id = ? 
        ORDER BY c.created_at DESC";

// Prepare the statement
$stmt = $conn->prepare($sql);

// Bind the parameter
$stmt->bind_param("i", $postid);

// Execute the statement
$stmt->execute();

// Get the result set
$result = $stmt->get_result();

$comments = array();

if ($result->num_rows > 0) {
    // Fetch data from each row
    while ($row = $result->fetch_assoc()) {
        $comments[] = $row;
    }
}

// Close the statement
$stmt->close();

// Close the connection
$conn->close();

// Output comments data as JSON
header('Content-Type: application/json');
echo json_encode($comments);
?>
