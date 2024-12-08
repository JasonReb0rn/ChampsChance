<?php

session_set_cookie_params(0, '/');
session_start();

require_once 'dbh.inc.php';
require '../vendor/autoload.php';

use Aws\S3\S3Client;
use Aws\Exception\AwsException;

if (isset($_POST['submit'])) {
    $value = $_POST['submitValue']; // This is the value for 1-3 sent via POST

    if (!is_numeric($value) || ($value < 1 || $value > 3)) {
        header("Location: /admin.php?error=invalid_value_" . $value);
        exit();
    }

    // Check if a file was uploaded successfully
    if ($_FILES['replaceCarouselImg']['error'] === UPLOAD_ERR_OK) {
        $tempName = $_FILES['replaceCarouselImg']['tmp_name'];
        $photoName = 'image-' . $value . '.jpg'; // Rename the image file based on its position

        $s3 = new S3Client([
            'version' => 'latest',
            'region'  => 'us-east-2',
            'credentials' => [
                'key'    => $_ENV['AWS_CC_KEY'],
                'secret' => $_ENV['AWS_CC_SECRET'],
            ],
        ]);

        // Delete the old image from S3 if it exists
        $stmt = $conn->prepare("SELECT image_name FROM carousel_images WHERE image_order = ?");
        $stmt->bind_param("i", $value);
        $stmt->execute();
        $stmt->bind_result($oldImageName);
        $stmt->fetch();
        $stmt->close();

        if ($oldImageName) {
            try {
                $s3->deleteObject([
                    'Bucket' => 'champschance',
                    'Key'    => 'assets/carousel/' . $oldImageName,
                ]);
            } catch (AwsException $e) {
                // Handle delete error if needed
            }
        }

        // Upload the new image to S3
        try {
            $result = $s3->putObject([
                'Bucket' => 'champschance',
                'Key'    => 'assets/carousel/' . $photoName,
                'SourceFile' => $tempName,
            ]);

            // Update the image name in the database
            $stmt = $conn->prepare("UPDATE carousel_images SET image_name = ?, user_id = ? WHERE image_order = ?");
            $stmt->bind_param("sii", $photoName, $_SESSION["userid"], $value);
            $stmt->execute();
            $stmt->close();

            header("Location: /admin.php?carousel_updated");
            exit();
        } catch (AwsException $e) {
            header("Location: /admin.php?error=upload_failed");
            exit();
        }
    } else {
        header("Location: /admin.php?error=no_file_uploaded");
        exit();
    }
} else {
    header("Location: /admin.php?error=invalid_request");
    exit();
}
?>
