<?php
session_start();
require_once 'dbh.inc.php';

// Create smaller (350px) thumbnail for uploaded image
$createThumbnail = function($imagePath, $thumbnailPath) {
    error_log("Creating thumbnail for: $imagePath");
    
    if (!list($originalWidth, $originalHeight) = getimagesize($imagePath)) {
        error_log("Failed to get image size for: $imagePath");
        return false;
    }
    
    // Calculate the aspect ratio
    $aspectRatio = $originalWidth / $originalHeight;
    
    // Maximum dimension
    $maxDimension = 350;
    
    // New dimensions while preserving aspect ratio
    if ($originalWidth > $originalHeight) {
        $newWidth = $maxDimension;
        $newHeight = $maxDimension / $aspectRatio;
    } else {
        $newWidth = $maxDimension * $aspectRatio;
        $newHeight = $maxDimension;
    }
    
    // Create thumbnail image
    $thumbnail = imagecreatetruecolor($newWidth, $newHeight);
    $sourceImageType = exif_imagetype($imagePath);
    
    switch ($sourceImageType) {
        case IMAGETYPE_JPEG:
            $source = imagecreatefromjpeg($imagePath);
            break;
        case IMAGETYPE_PNG:
            $source = imagecreatefrompng($imagePath);
            break;
        case IMAGETYPE_GIF:
            $source = imagecreatefromgif($imagePath);
            break;
        default:
            error_log("Unsupported image type for: $imagePath");
            return false; // Unsupported file type
    }

    // Resize the image
    imagecopyresampled($thumbnail, $source, 0, 0, 0, 0, $newWidth, $newHeight, $originalWidth, $originalHeight);
    
    // Save the thumbnail
    $result = imagejpeg($thumbnail, $thumbnailPath, 90);
    
    // Clean up
    imagedestroy($source);
    imagedestroy($thumbnail);
    
    return $result;
};

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Handle avatar upload/update
    $username = $_SESSION["useruid"];
    $userId = $_SESSION["userid"];

    // Check if a file was uploaded
    if (isset($_FILES["avatarFile"]) && $_FILES["avatarFile"]["error"] === UPLOAD_ERR_OK) {
        $targetDir = "../img/avatars/";
        $avatarName = $username . "-avatar.jpg";
        $targetFile = $targetDir . $avatarName;

        // Check if file already exists with the username (without timestamp)
        $existingFile = glob($targetDir . $username . "-avatar.*");
        if (!empty($existingFile)) {
            unlink($existingFile[0]); // Remove existing file
        }

        // Move the uploaded file to the target directory
        if (move_uploaded_file($_FILES["avatarFile"]["tmp_name"], $targetFile)) {
            // Resize the image if necessary
            $createThumbnail($targetFile, $targetFile); // Overwrite the original file with resized image

            // Avatar uploaded and resized successfully
            $avatarValue = $avatarName . '?' . time();

            // Update the avatar value in the database
            $sql = "UPDATE users SET usersAvatar = '$avatarValue' WHERE usersId = '$userId'";
            if ($conn->query($sql) === TRUE) {
                $_SESSION["userAvatar"] = $avatarValue;
                header("Location: ../profile.php?uploadsuccess");
                exit();
            } else {
                header("Location: ../profile.php?error=sqlerror");
                exit();
            }
        } else {
            // Error uploading avatar
            header("Location: ../profile.php?error=fileuploaderror");
            exit();
        }
    } else {
        // No file uploaded, set avatar as default
        $defaultAvatar = isset($_POST["avatarValue"]) ? $_POST["avatarValue"] : "default_dog_1.jpg";
        $_SESSION["userAvatar"] = $defaultAvatar;

        // Update the avatar value in the database
        $sql = "UPDATE users SET usersAvatar = '$defaultAvatar' WHERE usersId = '$userId'";
        if ($conn->query($sql) === TRUE) {
            header("Location: ../profile.php?defaultset");
            exit();
        } else {
            header("Location: ../profile.php?error=sqlerror");
            exit();
        }
    }
} else {
    header("Location: ../profile.php?error=invalidrequest");
    exit();
}
?>


