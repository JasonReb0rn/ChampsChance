document.addEventListener("DOMContentLoaded", function() {
    // Get the post_id from the data attribute
    var postId = document.getElementById('blog-post-container').getAttribute('data-post-id');

    // Send the post_id to the PHP script via AJAX
    var xhr = new XMLHttpRequest();
    xhr.open('POST', '../includes/article-view-tracker.inc.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        if (xhr.status === 200) {
            console.log('Views incremented successfully.');
        } else {
            console.error('Error incrementing views.');
        }
    };
    xhr.send('post_id=' + postId);
});