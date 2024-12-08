// Get the reference to the image elements
var editCarouselImg1 = document.getElementById("carousel-image-1");
var editCarouselImg2 = document.getElementById("carousel-image-2");
var editCarouselImg3 = document.getElementById("carousel-image-3");

// Function to fetch the JSON data with a cache-busting query parameter

var jsonUrl = "/includes/get-carousel-data.inc.php";
fetch(jsonUrl)
    .then((response) => {
        if (response.ok) {
            return response.json();
        } else {
            throw new Error("Error: " + response.status);
        }
    })
    .then((data) => {
        jsonData = data;
        carouselObjectsArray = jsonData.map((image) => ({
          photo: image.image_name,
          link: image.image_link,
        }));

        // Set the image source dynamically
        editCarouselImg1.src = "https://champschance.s3.us-east-2.amazonaws.com/assets/carousel/" + carouselObjectsArray[0].photo;
        editCarouselImg2.src = "https://champschance.s3.us-east-2.amazonaws.com/assets/carousel/" + carouselObjectsArray[1].photo;
        editCarouselImg3.src = "https://champschance.s3.us-east-2.amazonaws.com/assets/carousel/" + carouselObjectsArray[2].photo;
    })
    .catch((error) => {
        console.error("Error:", error);
    });

/*
// Get the reference to the image elements
var editCarouselImg1 = document.getElementById("carousel-image-1");
var editCarouselImg2 = document.getElementById("carousel-image-2");
var editCarouselImg3 = document.getElementById("carousel-image-3");

// Function to fetch the JSON data with a cache-busting query parameter

var jsonUrl = "/includes/get-carousel-data.inc.php";
fetch(jsonUrl)
    .then((response) => {
        if (response.ok) {
            return response.json();
        } else {
            throw new Error("Error: " + response.status);
        }
    })
    .then((data) => {
        // Move the code to set the image source inside the second `then` block
        // so that it executes after the JSON data is fetched
        carouselJsonData = data;
        carouselObjectsArray = carouselJsonData.images.map((images) => ({
            photo: images.photo,
        }));
        // Set the image source dynamically
        editCarouselImg1.src = "https://champschance.s3.us-east-2.amazonaws.com/assets/carousel/" + carouselObjectsArray[0].photo;
        editCarouselImg2.src = "https://champschance.s3.us-east-2.amazonaws.com/assets/carousel/" + carouselObjectsArray[1].photo;
        editCarouselImg3.src = "https://champschance.s3.us-east-2.amazonaws.com/assets/carousel/" + carouselObjectsArray[2].photo;
    })
    .catch((error) => {
        console.error("Error:", error);
    });
*/