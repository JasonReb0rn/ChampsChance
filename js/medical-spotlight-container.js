// blog-container.js

console.log("blog-container.js loaded");

let postsData;
let currentPage = 1;
const postsPerPage = 5;

document.addEventListener("DOMContentLoaded", function() {

    // Add event listener to handle pagination
    document.getElementById('blog-pages-container').addEventListener('click', handlePageClick);

    fetchPosts();

    // Get the query parameters from the URL
    const queryString = window.location.search;
    // Check if the query string contains '?article-upload-success'
    if (queryString.includes('?article-upload-success')) {
        // Get the current URL
        let currentUrl = window.location.href;
        // Remove the '?article-upload-success' part from the URL
        currentUrl = currentUrl.replace('?article-upload-success', '');
        // Replace the current URL without '?article-upload-success' in the browser history
        window.history.replaceState(null, null, currentUrl);
        forceRefreshData();
    }

});

// Function to handle pagination click events
function handlePageClick(event) {
    event.preventDefault();
    const target = event.target;
    if (target.tagName === 'A') {
        const pageNumber = parseInt(target.textContent);
        if (!isNaN(pageNumber)) {
            currentPage = pageNumber;
            drawPosts('');
        } else if (target.textContent === '<') {
            if (currentPage > 1) {
                currentPage--;
                drawPosts('');
            }
        } else if (target.textContent === '>') {
            const maxPage = Math.ceil(postsData.length / postsPerPage);
            if (currentPage < maxPage) {
                currentPage++;
                drawPosts('');
            }
        }
    }
}

// Function to fetch posts from server
function fetchPosts() {
    if (shouldFetchNewData()) {
        console.log("Posts data NOT cached! Fetching new data.");
        let xhr = new XMLHttpRequest();
        xhr.open("GET", "../includes/get-blog-posts.inc.php", true);
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                // Store data and timestamp in local storage
                localStorage.setItem('postsData', xhr.responseText);
                localStorage.setItem('lastFetchTimeBlog', new Date().getTime().toString());
                handlePostsData(xhr.responseText);
            }
        };
        xhr.send();
    } else {
        // Use cached data
        console.log("Using cached posts data.");
        handlePostsData(localStorage.getItem('postsData'));
    }
}

// Helper function to check if data should be fetched
function shouldFetchNewData() {
    const lastFetch = localStorage.getItem('lastFetchTimeBlog');
    if (!lastFetch) {
        return true; // No data has been fetched before
    }
    const now = new Date().getTime();
    const oneHour = 1000 * 60 * 60; // milliseconds in one hour
    return now - parseInt(lastFetch) > oneHour; // Check if last fetch was more than an hour ago
}

function forceRefreshData() {
    console.log("Force Refresh Data!");
    // Clear cached data
    localStorage.removeItem('postsData');
    localStorage.removeItem('lastFetchTimeBlog');
    // Fetch new data
    fetchPosts();
}

// Function to handle posts data
function handlePostsData(response) {
    // Parse the JSON data into a JavaScript object
    postsData = JSON.parse(response);
    // Call function to draw posts
    drawPosts('');
}

// Function to draw posts on the page
function drawPosts(searchTerm) {
    console.log("drawPosts on medical spotlight.");
    const postContainer = document.getElementById('blog-posts-container');
    postContainer.innerHTML = ""; // Clear previous content

    let medicalSearchTerm = 'medical_spotlight';

    let filteredPosts = postsData;

    // Filter posts based on the category search term
    filteredPosts = postsData.filter(post => post.category === medicalSearchTerm);
 
    const startIndex = (currentPage - 1) * postsPerPage;
    const endIndex = startIndex + postsPerPage;
    const postsToDisplay = filteredPosts.slice(startIndex, endIndex);

    console.log(postsData);

    postsToDisplay.forEach(function (post, index) {
        const postElement = document.createElement('div');
        postElement.classList.add('blog-post');
        

        const imgContainer = document.createElement('div');
        imgContainer.classList.add('blog-img-container');
        const imgLink = document.createElement('a'); // Anchor tag to wrap the image
        imgLink.href = 'articles/article-' + post.post_id + '.php';
        const img = document.createElement('img');
        img.src = 'https://champschance.s3.us-east-2.amazonaws.com/blog/img/' + post.photo;
        img.alt = 'picture';
        imgLink.appendChild(img);
        imgContainer.appendChild(imgLink);

        const infoContainer = document.createElement('div');
        infoContainer.classList.add('blog-info-container');

        const categoryLink = document.createElement('a');
        categoryLink.classList.add('category-link');
        const category = document.createElement('h1');
        category.classList.add('post-category');

        const originalCategory = post.category;
        const encodedCategory = encodeURIComponent(originalCategory);
        
        categoryLink.href = 'blog.php?search=' + encodedCategory;
        category.textContent = formattedCategory(post.category);
        categoryLink.appendChild(category);

        const title_container = document.createElement('h2');
        const title = document.createElement('a');
        title.classList.add('post-title')
        title.href = 'articles/article-' + post.post_id + '.php';
        title.textContent = post.title;

        const meta = document.createElement('div');
        meta.classList.add('post-meta');
        meta.innerHTML = `By <span class="author">${post.usersUid}</span> | Posted on <span class="post-date">${post.formatted_created_at}</span>`;

        const content = document.createElement('div');
        content.classList.add('post-content');


        // Extract text from <p> tags in post content
        const tempElement = document.createElement('div');
        tempElement.innerHTML = post.content;
        const paragraphs = tempElement.getElementsByTagName('p');
        let paragraphContent = '';
        for (let i = 0; i < paragraphs.length; i++) {
            paragraphContent += paragraphs[i].textContent + ' ';
        }


        const truncatedContent = truncateText(paragraphContent, 600); // Truncate content to first 200 words
        content.innerHTML = truncatedContent;

        const readMore = document.createElement('a');
        readMore.classList.add('read-more');
        readMore.href = 'articles/article-' + post.post_id + '.php';
        readMore.textContent = 'Read more...';
        readMore.dataset.index = index; // Store index of post for event handling

        content.appendChild(readMore);

        infoContainer.appendChild(categoryLink);
        infoContainer.appendChild(title_container);
        title_container.appendChild(title);
        infoContainer.appendChild(meta);
        infoContainer.appendChild(content);

        postElement.appendChild(imgContainer);
        postElement.appendChild(infoContainer);

        postContainer.appendChild(postElement);
    });

    // Call function to draw page numbers
    drawPageNumbers(filteredPosts);
}

// Function to truncate text to a specified length
function truncateText(text, maxLength) {
    if (text.length <= maxLength) {
        return text;
    }
    return text.substr(0, maxLength) + '...';
}

// Function to format category
function formattedCategory(categoryString) {
    // Split the string by underscore
    const words = categoryString.split('_');
    // Capitalize the first letter of each word and join with a space
    const formattedCategory = words.map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(' ');
    return formattedCategory;
}

// Function to draw page numbers
function drawPageNumbers(postList) {
    const totalPages = Math.ceil(postList.length / postsPerPage);
    const pageContainer = document.querySelector('.page-numbers');
    pageContainer.innerHTML = ""; // Clear previous content

    // Add previous page link
    const prevPage = document.createElement('li');
    prevPage.classList.add('arrow');
    const prevLink = document.createElement('a');
    prevLink.href = '#';
    prevLink.textContent = '<';
    prevPage.appendChild(prevLink);
    pageContainer.appendChild(prevPage);

    // Add page links
    for (let i = 1; i <= totalPages; i++) {
        const pageItem = document.createElement('li');
        const pageLink = document.createElement('a');
        pageLink.href = '#';
        pageLink.textContent = i;
        pageItem.appendChild(pageLink);
        if (i === currentPage) {
            pageItem.classList.add('current');
        }
        pageContainer.appendChild(pageItem);
    }

    // Add next page link
    const nextPage = document.createElement('li');
    nextPage.classList.add('arrow');
    const nextLink = document.createElement('a');
    nextLink.href = '#';
    nextLink.textContent = '>';
    nextPage.appendChild(nextLink);
    pageContainer.appendChild(nextPage);
}
