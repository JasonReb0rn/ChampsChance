<?php

session_start();
require_once 'dbh.inc.php';
require '../vendor/autoload.php';

use Aws\S3\S3Client;
use Aws\Exception\AwsException;

// AWS credentials and S3 bucket name
$bucketName = 'champschance';
$accessKeyId = $_ENV['AWS_CC_KEY'];
$secretAccessKey = $_ENV['AWS_CC_SECRET'];
$region = 'us-east-2';

// Create an S3Client
$s3Client = new S3Client([
    'version' => 'latest',
    'region' => $region,
    'credentials' => [
        'key' => $accessKeyId,
        'secret' => $secretAccessKey
    ]
]);                 

if (isset($_POST["submit"])) {
    // Get form data
    $postTitle = $_POST["postTitle"];
    $postContent = $_POST["postContent"];
    $postCategory = $_POST["postCategory"];
    
    // Check if user is logged in
    if (!isset($_SESSION["userid"])) {
        // Handle the case where user is not logged in
        header("Location: ../login.php?error=notloggedin");
        exit();
    }

    // Check if post content is empty
    if (empty($postContent)) {
        // Handle the case where post content is empty
        header("Location: ../blog.php?error=emptycontent");
        exit();
    }

    // Retrieve author_id from session
    $authorId = $_SESSION["userid"];

    // File handling
    $fileName = basename($_FILES["postImage"]["name"]);
    $fileTempName = $_FILES["postImage"]["tmp_name"];

    // Upload file to S3
    try {
        $result = $s3Client->putObject([
            'Bucket' => $bucketName,
            'Key' => 'blog/img/' . $fileName,
            'Body' => fopen($fileTempName, 'rb')
        ]);

        $encodedPostContent = $postContent;

        // Insert data into database
        $sql = "INSERT INTO posts (title, content, author_id, photo, category) VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_stmt_init($conn);
        if (mysqli_stmt_prepare($stmt, $sql)) {
        mysqli_stmt_bind_param($stmt, "ssiss", $postTitle, $encodedPostContent, $authorId, $fileName, $postCategory);
        mysqli_stmt_execute($stmt);

        // Get the ID of the inserted post
        $postId = mysqli_insert_id($conn);

        mysqli_stmt_close($stmt);

        // Query to retrieve posts
        $sql = "SELECT p.*, u.usersUid, u.usersAvatar 
                FROM posts p 
                JOIN users u ON p.author_id = u.usersId
                WHERE p.post_id = ?";
        $stmt = mysqli_stmt_init($conn);
        if (mysqli_stmt_prepare($stmt, $sql)) {
            mysqli_stmt_bind_param($stmt, "i", $postId);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            // Fetch data from the result
            $post = mysqli_fetch_assoc($result);
            // Close the statement
            mysqli_stmt_close($stmt);
        }

        $shortenedTitle = shortenString($post['title']);
        $cleanedCategory = cleanUpString($post['category']);

        // Extract 'created_at' value from $_POST
        $createdAt = $post['created_at'];
        // Format 'created_at' value
        $cleanedCreatedAt = date('F jS Y \a\t h:ia', strtotime($createdAt));

        $templatePath = "../article.php";
        if (file_exists($templatePath)) {
            // Start output buffering
            ob_start();
            include $templatePath;
            $htmlContent = ob_get_clean();

            $htmlContent = '<?php session_start(); ?>' . $htmlContent;
            $htmlContent = str_replace('<!--HEADER-->', '<?php include_once \'../header.php\'; ?>', $htmlContent);
            $htmlContent = str_replace('<!--FOOTER-->', '<?php include_once \'../footer.php\'; ?>', $htmlContent);
            $htmlContent = str_replace('<!--COMMENT-->', '<?php include_once \'../comment-form.php\'; ?>', $htmlContent);
            $htmlContent = str_replace('<!--VIEW-->', '<?php include_once \'../comment-form.php\'; ?>', $htmlContent);
            $htmlContent = str_replace('<!--DELETE-BUTTON-->', '<?php if (isset($_SESSION["usersperm"]) && $_SESSION["usersperm"] == 1): ?>
                <form action="../includes/delete-blog-post.inc.php" method="post">
                    <input type="hidden" name="post_id" value="' . $postId . '">
                    <button type="submit" name="delete" class="delete-post-btn"><i class="fa-solid fa-trash"></i> Delete Article</button>
                </form>
            <?php endif; ?>', $htmlContent);

            // Save HTML content to a file
            $articleFileName = "article-{$postId}.php";
            $articleFilePath = "../articles/{$articleFileName}";
            file_put_contents($articleFilePath, $htmlContent);

        }

        // The article uploaded successfully
        // Log the action
        $user_id = $_SESSION["userid"];
        $log_ip = $_SERVER['REMOTE_ADDR']; // Get the user's IP address
        $log_action = "Blog post created"; // Log the updated image details
        $user_agent = $_SERVER['HTTP_USER_AGENT'];

        // Include the necessary file
        require_once 'create-log.inc.php'; // Assuming this file contains the insertLog function

        // Call the insertLog function to create the log entry
        insertLog($conn, $user_id, $log_ip, $log_action, $user_agent);

        // Update sitemap
        $articleURL = "https://champschance.org/articles/article-" . $postId . ".php";
        updateSitemap($articleURL);

        header("Location: ../blog.php?article-upload-success");
        // Redirect to success page or display success message
        // header("Location: ../articles/article-" . $postId . ".php");
        exit();
        
        } else {
            // Error handling if SQL statement fails
            header("Location: ../blog.php?error=sqlerror");
            exit();
        }
    } catch (AwsException $e) {
        echo $e->getMessage();
    }
} else {
    // Redirect back if form was not submitted properly
    header("Location: ../blog.php");
    exit();
}

function shortenString($inputString, $maxWords = 20) {
    // Split the string into words
    $words = preg_split("/\s+/", $inputString);

    // Select the first $maxWords words
    $shortenedWords = array_slice($words, 0, $maxWords);

    // Join the words back into a string
    $shortenedString = implode(' ', $shortenedWords);

    // Append an ellipsis if the original string was longer
    if (count($words) > $maxWords) {
        $shortenedString .= '...';
    }

    return $shortenedString;
}

function cleanUpString($str) {
    // Remove underscores and capitalize each word
    $cleanedStr = ucwords(str_replace('_', ' ', $str));
    
    return $cleanedStr;
}

function updateSitemap($articleURL) {
    $sitemapFile = "../sitemap.xml"; // Path to your sitemap.xml file
    $sitemap = simplexml_load_file($sitemapFile);
    
    // Create a new <url> element for the article
    $url = $sitemap->addChild('url');
    $url->addChild('loc', $articleURL);
    $url->addChild('lastmod', date('Y-m-d'));
    $url->addChild('changefreq', 'weekly');
    $url->addChild('priority', '0.7');

    // Save the updated sitemap.xml file
    $sitemap->asXML($sitemapFile);
}