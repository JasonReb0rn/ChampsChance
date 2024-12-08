<?php
// Include the database connection file
require_once 'dbh.inc.php';

// Function to insert a log entry into the database
function insertLog($conn, $user_id, $log_ip, $log_action, $user_agent) {
    $stmt = $conn->prepare("INSERT INTO log (user_id, log_ip, log_action, user_agent) VALUES (?, ?, ?, ?)");

    if (!$stmt) {
        echo "Error preparing statement: " . $conn->error;
        return;
    }

    $stmt->bind_param("isss", $user_id, $log_ip, $log_action, $user_agent);

    if (!$stmt->execute()) {
        echo "Error inserting log entry: " . $stmt->error;
    }

    $stmt->close();
}
