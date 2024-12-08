<?php

require_once 'dbh.inc.php'; // Assuming this file contains the database connection details

// Fetch carousel images from the database
$stmt = $conn->prepare("SELECT image_name, image_link FROM carousel_images ORDER BY image_order");
$stmt->execute();
$result = $stmt->get_result();
$carouselData = array();
while ($row = $result->fetch_assoc()) {
    $carouselData[] = $row;
}
$stmt->close();

// Return the data as JSON
header('Content-Type: application/json');
echo json_encode($carouselData);
?>
