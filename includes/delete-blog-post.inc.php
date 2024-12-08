<?php
session_start();
require_once 'dbh.inc.php';
require '../vendor/autoload.php';

use Aws\S3\S3Client;
use Aws\Exception\AwsException;

if (isset($_POST["delete"]) && isset($_SESSION["usersperm"]) && $_SESSION["usersperm"] == 1) {
    $post_id = $_POST["post_id"];
    
    // Get post info before deletion
    $sql = "SELECT photo FROM posts WHERE post_id = ?";
    $stmt = mysqli_stmt_init($conn);
    if (mysqli_stmt_prepare($stmt, $sql)) {
        mysqli_stmt_bind_param($stmt, "i", $post_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $post = mysqli_fetch_assoc($result);
        
        // Delete image from S3
        $s3Client = new S3Client([
            'version' => 'latest',
            'region'  => 'us-east-2',
            'credentials' => [
                'key'    => $_ENV['AWS_CC_KEY'],
                'secret' => $_ENV['AWS_CC_SECRET']
            ]
        ]);

        try {
            $s3Client->deleteObject([
                'Bucket' => 'champschance',
                'Key'    => 'blog/img/' . $post['photo']
            ]);
        } catch (AwsException $e) {
            error_log($e->getMessage());
        }

        $sql = "DELETE FROM comments WHERE post_id = ?";
        if (mysqli_stmt_prepare($stmt, $sql)) {
            mysqli_stmt_bind_param($stmt, "i", $post_id);
            mysqli_stmt_execute($stmt);
        }
        
        // Delete related views
        $sql = "DELETE FROM views WHERE post_id = ?";
        if (mysqli_stmt_prepare($stmt, $sql)) {
            mysqli_stmt_bind_param($stmt, "i", $post_id);
            mysqli_stmt_execute($stmt);
        }

        // Delete from database
        $sql = "DELETE FROM posts WHERE post_id = ?";
        if (mysqli_stmt_prepare($stmt, $sql)) {
            mysqli_stmt_bind_param($stmt, "i", $post_id);
            mysqli_stmt_execute($stmt);
        }

        // Delete article file
        unlink("../articles/article-{$post_id}.php");

        header("Location: ../blog.php?deleted=success");
        exit();
    }
}

header("Location: ../blog.php?error=failed");
exit();