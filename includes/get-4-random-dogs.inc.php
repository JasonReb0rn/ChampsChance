<?php

require_once 'dbh.inc.php';

// Query to retrieve posts
// Retrieves ALL posts, plus the associated username of the post, SORTED by date descending (newest at top)
$sql = "SELECT *
        FROM animals
        ORDER BY RAND()
        LIMIT 4";

$result = $conn->query($sql);

// Quary to retrieve users

$dogs = array();

if ($result->num_rows > 0) {
    // Fetch data from each row
    while ($row = $result->fetch_assoc()) {
        $dogs[] = $row;
    }
}

// Close the connection
$conn->close();

// Output dogs data as JSON
header('Content-Type: application/json');
echo json_encode($dogs);
?>

