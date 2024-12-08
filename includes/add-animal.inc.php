<?php
session_start();

require_once 'dbh.inc.php';
require '../vendor/autoload.php';

use Aws\S3\S3Client;
use Aws\Exception\AwsException;

// ADD DOG
function addAnimalToJson($conn, $animalData) {
    // Prepare SQL statement
    $sql = "INSERT INTO animals (name, photo, photo2, photo3, description, status, breed, age, color, gender, size, fee, notes) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../admin.php?error=sqlerror");
        exit();
    }

    // Execute SQL statement with prepared data
    mysqli_stmt_bind_param($stmt, "sssssssssssss", $animalData['name'], $animalData['photo'], $animalData['photo2'], $animalData['photo3'], $animalData['description'], $animalData['status'], $animalData['breed'], $animalData['age'], $animalData['color'], $animalData['gender'], $animalData['size'], $animalData['fee'], $animalData['notes']);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    // Log the action
    $user_id = $_SESSION["userid"];
    $log_ip = $_SERVER['REMOTE_ADDR']; // Get the user's IP address
    $log_action = "Animal added: " . json_encode($animalData); // Log the added animal data
    $user_agent = $_SERVER['HTTP_USER_AGENT'];

    // Include the necessary file
    require_once 'create-log.inc.php'; // Assuming this file contains the insertLog function

    // Call the insertLog function to create the log entry
    insertLog($conn, $user_id, $log_ip, $log_action, $user_agent);

    header("location: ../admin.php?animaladded");
    exit();
}

// REMOVE DOG
function removeAnimalFromJson($conn, $id) {
    // Retrieve existing filenames and delete from S3
    $existingFilenames = getExistingImageFilenames($conn, $id);
    $s3 = new S3Client([
        'version' => 'latest',
        'region'  => 'us-east-2',
        'credentials' => [
            'key'    => $_ENV['AWS_CC_KEY'],
            'secret' => $_ENV['AWS_CC_SECRET'],
        ],
    ]);

    foreach ($existingFilenames as $filename) {
        try {
            $s3->deleteObject([
                'Bucket' => 'champschance',
                'Key'    => 'dogs/' . $filename,
            ]);
            $s3->deleteObject([
                'Bucket' => 'champschance',
                'Key'    => 'dog-thumbnails/' . pathinfo($filename, PATHINFO_FILENAME) . '.jpg',
            ]);
        } catch (AwsException $e) {
            error_log($e->getMessage());
        }
    }

    // Prepare SQL statement
    $sql = "DELETE FROM animals WHERE id=?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../admin.php?error=sqlerror");
        exit();
    }

    // Execute SQL statement with prepared data
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    // Log the action
    $user_id = $_SESSION["userid"];
    $log_ip = $_SERVER['REMOTE_ADDR']; // Get the user's IP address
    $log_action = "Dog '$dogName' removed from JSON at index: $id"; // Log the removed animal index
    $user_agent = $_SERVER['HTTP_USER_AGENT'];

    // Include the necessary file
    require_once 'create-log.inc.php'; // Assuming this file contains the insertLog function

    // Call the insertLog function to create the log entry
    insertLog($conn, $user_id, $log_ip, $log_action, $user_agent);

    // header("location: ../admin.php?removed&i=" . $i);
    header("location: ../admin.php?removed");
    exit();
}


function getExistingImageFilenames($conn, $id) {
    $sql = "SELECT photo, photo2, photo3 FROM animals WHERE id = ?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../admin.php?error=sqlerror");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        $filenames = array_filter($row, function($value) {
            return !is_null($value) && $value !== '';
        });
        mysqli_stmt_close($stmt);
        return $filenames;
    }

    mysqli_stmt_close($stmt);
    return array();
}

function nameMoveDogImage($conn, $dogName, $dogImage, $dogImage2, $dogImage3) {
    $filenames = [];

    // Instantiate an S3 client
    $s3 = new S3Client([
        'version' => 'latest',
        'region'  => 'us-east-2', // Replace 'your-region' with your AWS region
        'credentials' => [
            'key'    => $_ENV['AWS_CC_KEY'],
            'secret' => $_ENV['AWS_CC_SECRET'],
        ],
    ]);

    $createThumbnail = function($imagePath) {
        if (!list($originalWidth, $originalHeight) = getimagesize($imagePath)) {
            error_log("Failed to get image size for: $imagePath");
            return false;
        }
        
        $aspectRatio = $originalWidth / $originalHeight;
    
        // Calculate thumbnail dimensions as integers
        $thumbnailWidth = (int) ($originalWidth > $originalHeight ? 500 : (500 * $aspectRatio));
        $thumbnailHeight = (int) ($originalHeight > $originalWidth ? 500 : (500 / $aspectRatio));
    
        $thumbnail = imagecreatetruecolor($thumbnailWidth, $thumbnailHeight);
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
    
        imagecopyresampled($thumbnail, $source, 0, 0, 0, 0, $thumbnailWidth, $thumbnailHeight, $originalWidth, $originalHeight);
        imagedestroy($source);
        return $thumbnail;
    };

    // Process each image
    foreach ([$dogImage, $dogImage2, $dogImage3] as $index => $image) {
        if (!empty($image['name']) && $image['error'] === UPLOAD_ERR_OK) {
            $baseFilename = $dogName . '_' . ($index + 1) . '_' . uniqid();
            $filename = $baseFilename . '.jpg';

            // Upload original image to S3 bucket
            try {
                $result = $s3->putObject([
                    'Bucket' => 'champschance',
                    'Key'    => 'dogs/' . $filename,
                    'Body'   => fopen($image['tmp_name'], 'rb')
                ]);

                // Add uploaded filename to the list
                $filenames[$index] = $filename;
            } catch (AwsException $e) {
                error_log($e->getMessage());
                $filenames[$index] = null;
            }

            // Create thumbnail in memory and upload to S3 bucket
            try {
                $thumbnail = $createThumbnail($image['tmp_name']);
                if ($thumbnail) {
                    $thumbnailFilename = $baseFilename . '.jpg';
                    ob_start();
                    imagejpeg($thumbnail, null, 90);
                    $thumbnailData = ob_get_clean();

                    $result = $s3->putObject([
                        'Bucket' => 'champschance',
                        'Key'    => 'dog-thumbnails/' . $thumbnailFilename,
                        'Body'   => $thumbnailData
                    ]);

                    imagedestroy($thumbnail);
                }
            } catch (AwsException $e) {
                error_log($e->getMessage());
            }
        } else {
            $filenames[$index] = null;
        }
    }

    http_response_code(200);
    return $filenames;
}

// $$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$
// EDITING    EDITING    EDITING    EDITING    EDITING    EDITING    EDITING    EDITING    EDITING    
// $$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$

function editExistingDog($conn, $id, $editAnimalData) {
    
    $existingRecord = getExistingRecord($conn, $id);

    // Instantiate an S3 client
    $s3 = new S3Client([
        'version' => 'latest',
        'region'  => 'us-east-2',
        'credentials' => [
            'key'    => $_ENV['AWS_CC_KEY'],
            'secret' => $_ENV['AWS_CC_SECRET'],
        ],
    ]);

    // Delete existing images from S3 if they're being replaced
    $imagesToDelete = [];
    if ($editAnimalData['photo'] !== null && $editAnimalData['photo'] !== $existingRecord['photo']) {
        $imagesToDelete[] = $existingRecord['photo'];
    }
    if ($editAnimalData['photo2'] !== null && $editAnimalData['photo2'] !== $existingRecord['photo2']) {
        $imagesToDelete[] = $existingRecord['photo2'];
    }
    if ($editAnimalData['photo3'] !== null && $editAnimalData['photo3'] !== $existingRecord['photo3']) {
        $imagesToDelete[] = $existingRecord['photo3'];
    }

    foreach ($imagesToDelete as $filename) {
        try {
            $s3->deleteObject([
                'Bucket' => 'champschance',
                'Key'    => 'dogs/' . $filename,
            ]);
            $s3->deleteObject([
                'Bucket' => 'champschance',
                'Key'    => 'dog-thumbnails/' . $filename,
            ]);
        } catch (AwsException $e) {
            error_log($e->getMessage());
        }
    }

    // Prepare SQL statement
    $sql = "UPDATE animals SET name=?, description=?, status=?, breed=?, age=?, color=?, gender=?, size=?, fee=?, notes=?";
    $params = array($editAnimalData['name'], $editAnimalData['description'], $editAnimalData['status'], $editAnimalData['breed'], $editAnimalData['age'], $editAnimalData['color'], $editAnimalData['gender'], $editAnimalData['size'], $editAnimalData['fee'], $editAnimalData['notes']);

    // Include photo columns if they are not null
    if ($editAnimalData['photo'] !== null) {
        $sql .= ", photo=?";
        $params[] = $editAnimalData['photo'];
    }
    if ($editAnimalData['photo2'] !== null) {
        $sql .= ", photo2=?";
        $params[] = $editAnimalData['photo2'];
    }
    if ($editAnimalData['photo3'] !== null) {
        $sql .= ", photo3=?";
        $params[] = $editAnimalData['photo3'];
    }

    $sql .= " WHERE id=?";
    $params[] = $id;

    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../admin.php?error=sqlerror");
        exit();
    }

    // Execute SQL statement with prepared data
    mysqli_stmt_bind_param($stmt, str_repeat('s', count($params)), ...$params);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    // Log the action
    $user_id = $_SESSION["userid"];
    $log_ip = $_SERVER['REMOTE_ADDR']; // Get the user's IP address
    $log_action = "Dog '" . $editAnimalData["name"] . "' edited at index $id with data: " . json_encode($editAnimalData); // Log the edited animal data
    $user_agent = $_SERVER['HTTP_USER_AGENT'];

    // Include the necessary file
    require_once 'create-log.inc.php'; // Assuming this file contains the insertLog function

    // Call the insertLog function to create the log entry
    insertLog($conn, $user_id, $log_ip, $log_action, $user_agent);

    // header("Location: ../admin.php?edited&i=" . $arrayNum);
    header("Location: ../admin.php?edited");
    exit();
}

function getExistingRecord($conn, $id) {
    $sql = "SELECT photo, photo2, photo3 FROM animals WHERE id = ?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../admin.php?error=sqlerror");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        mysqli_stmt_close($stmt);
        return $row;
    }

    mysqli_stmt_close($stmt);
    return array();
}

function RemoveImage($conn, $id, $imageNum) {
    
    // Determine which photo field to update based on imageNum
    $photoField = '';
    switch ($imageNum) {
        case 2:
            $photoField = 'photo2';
            break;
        case 3:
            $photoField = 'photo3';
            break;
        default:
            return; // Invalid image number
    }

    // Get the existing filename for the image being removed
    $existingFilename = getExistingImageFilename($conn, $id, $photoField);

    // Instantiate an S3 client
    $s3 = new S3Client([
        'version' => 'latest',
        'region'  => 'us-east-2',
        'credentials' => [
            'key'    => $_ENV['AWS_CC_KEY'],
            'secret' => $_ENV['AWS_CC_SECRET'],
        ],
    ]);

    // Delete the image and its thumbnail from S3, if it exists
    if ($existingFilename) {
        try {
            $s3->deleteObject([
                'Bucket' => 'champschance',
                'Key'    => 'dogs/' . $existingFilename,
            ]);
            $s3->deleteObject([
                'Bucket' => 'champschance',
                'Key'    => 'dog-thumbnails/' . $existingFilename,
            ]);
        } catch (AwsException $e) {
            error_log($e->getMessage());
        }
    }

    // Prepare SQL statement to set the photo field to NULL
    $sql = "UPDATE animals SET $photoField=NULL WHERE id=?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../admin.php?error=sqlerror");
        exit();
    }

    // Execute SQL statement with prepared data
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    // Log the action
    $user_id = $_SESSION["userid"];
    $log_ip = $_SERVER['REMOTE_ADDR']; // Get the user's IP address
    $log_action = "Image $imageNum removed from dog $id."; // Log the removed image index and dog's name
    $user_agent = $_SERVER['HTTP_USER_AGENT'];

    // Include the necessary file
    require_once 'create-log.inc.php'; // Assuming this file contains the insertLog function

    // Call the insertLog function to create the log entry
    insertLog($conn, $user_id, $log_ip, $log_action, $user_agent);

    // header("Location: ../admin.php?removed&imgnum=" . $imgNum);
    header("Location: ../admin.php?removedimg");
    exit();
}


function getExistingImageFilename($conn, $id, $photoField) {
    $sql = "SELECT $photoField FROM animals WHERE id = ?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../admin.php?error=sqlerror");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        mysqli_stmt_close($stmt);
        return $row[$photoField];
    }

    mysqli_stmt_close($stmt);
    return null;
}

// $$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$
// SUBMITTING    SUBMITTING    SUBMITTING    SUBMITTING    SUBMITTING    SUBMITTING    SUBMITTING
// $$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$

if (isset($_POST["submit"])) {

    $dogName = $_POST["dogName"];
    $dogDescription = $_POST["dogDescription"];
    $dogStatus = $_POST["dogStatus"];
    $dogBreed = $_POST["dogBreed"];
    $dogAge = $_POST["dogAge"];
    $dogColor = $_POST["dogColor"];
    $dogGender = $_POST["dogGender"];
    $dogSize = $_POST["dogSize"];
    $dogFee = $_POST["dogFee"];
    //$dogMedicalNeeds = $_POST["dogMedicalNeeds"];
    $dogNotes = $_POST["dogNotes"];

    $dogImage = $_FILES["dogImage"];
    $dogImage2 = $_FILES["dogImage2"];
    $dogImage3 = $_FILES["dogImage3"];

    $filenames = nameMoveDogImage($conn, $dogName, $dogImage, $dogImage2, $dogImage3);

    $animalData = array(
        "name" => $dogName,
        "photo" => $filenames[0],
        "photo2" => isset($filenames[1]) ? $filenames[1] : null,
        "photo3" => isset($filenames[2]) ? $filenames[2] : null,
        "description" => $dogDescription,
        "status" => $dogStatus,
        "breed" => $dogBreed,
        "age" => $dogAge,
        "color" => $dogColor,
        "gender" => $dogGender,
        "size" => $dogSize,
        "fee" => $dogFee,
        //"medical_needs" => $dogMedicalNeeds,
        "notes" => $dogNotes !== "" ? $dogNotes : null,
    );    

    addAnimalToJson($conn, $animalData);

} else if (isset($_POST["edit"])) {

    $dogName = $_POST["dogName"];
    $dogDescription = $_POST["dogDescription"];
    $dogStatus = $_POST["dogStatus"];
    $dogBreed = $_POST["dogBreed"];
    $dogAge = $_POST["dogAge"];
    $dogColor = $_POST["dogColor"];
    $dogGender = $_POST["dogGender"];
    $dogSize = $_POST["dogSize"];
    $dogFee = $_POST["dogFee"];
    //$dogMedicalNeeds = isset($_POST["dogMedicalNeeds"]) ? $_POST["dogMedicalNeeds"] : "off";
    $dogNotes = $_POST["dogNotes"];

    $dogImage = $_FILES["editUploadImg1"];
    $dogImage2 = $_FILES["editUploadImg2"];
    $dogImage3 = $_FILES["editUploadImg3"];

    $dogARRAYelement = $_POST["edit"];

    $filenames = nameMoveDogImage($conn, $dogName, $dogImage, $dogImage2, $dogImage3, $dogARRAYelement);

    $editAnimalData = array(
        "name" => $dogName,
        "photo" => isset($filenames[0]) ? $filenames[0] : null,
        "photo2" => isset($filenames[1]) ? $filenames[1] : null,
        "photo3" => isset($filenames[2]) ? $filenames[2] : null,
        "description" => $dogDescription,
        "status" => $dogStatus,
        "breed" => $dogBreed,
        "age" => $dogAge,
        "color" => $dogColor,
        "gender" => $dogGender,
        "size" => $dogSize,
        "fee" => $dogFee,
        //"medical_needs" => $dogMedicalNeeds,
        "notes" => $dogNotes
    );

    editExistingDog($conn, $dogARRAYelement, $editAnimalData);

    header("Location: ../admin.php?error=editDog-" . $dogARRAYelement);
    exit;
} else if (isset($_POST["delete"])) {

    $dogARRAYelement = $_POST["delete"];
    removeAnimalFromJson($conn, $dogARRAYelement);
    header("Location: ../admin.php?error=removeDog-" . $dogARRAYelement);
    exit;

} else if (isset($_POST["removeImg2"])) {

    $dogARRAYelement = $_POST["removeImg2"];

    RemoveImage($conn, $dogARRAYelement, 2);

    header("Location: ../admin.php?error=removeImg2-" . $dogARRAYelement);
    exit;

} else if (isset($_POST["removeImg3"])) {

    $dogARRAYelement = $_POST["removeImg3"];

    RemoveImage($conn, $dogARRAYelement, 3);

    header("Location: ../admin.php?error=removeImg3-" . $dogARRAYelement);
    exit;

}else {
    header("location: ../admin.php?noPOST");
    exit();
}