
fetch("/includes/get-carousel-data.inc.php")
  .then((response) => {
    if (response.ok) {
      return response.json();
    } else {
      throw new Error("Error: " + response.status);
    }
  })
  .then((data) => {
    jsonData = data;
    objectsArray = jsonData.images.map((images) => ({
      photo: images.photo,
    }));
    // Get all elements with the class "carousel-img"
    var carouselImages = document.querySelectorAll(".carousel-img");
    // Set the image source dynamically for each element and update the href of the corresponding <a> tag
    carouselImages.forEach((img) => {
      const index = parseInt(img.dataset.index, 10);
      const photoURL = "https://champschance.s3.us-east-2.amazonaws.com/assets/carousel/" + objectsArray[index].photo;
      // Set the src attribute of the image
      img.src = photoURL;
      // Get all <a> tags with the matching data-index attribute
      var links = document.querySelectorAll(`a[data-index="${index}"]`);
      // Update the href attribute of each matching <a> tag
      links.forEach((link) => {
        link.href = photoURL;
      });
    });
  })
  .catch((error) => {
    console.error("Error:", error);
  });















/*
fetch("/includes/get-carousel-data.inc.php")
  .then((response) => {
    if (response.ok) {
      return response.json();
    } else {
      throw new Error("Error: " + response.status);
    }
  })
  .then((data) => {
    jsonData = data;
    objectsArray = jsonData.map((image) => ({
      photo: image.image_name,
    }));

    // Get all elements with the class "carousel-img"
    var carouselImages = document.querySelectorAll(".carousel-img");

    // Set the image source dynamically for each element and update the href of the corresponding <a> tag
    carouselImages.forEach((img, index) => {
      img.src = "https://champschance.s3.us-east-2.amazonaws.com/assets/carousel/" + objectsArray[index].photo;

      // Get the corresponding <a> tag using the index
      var link = document.querySelector(`a[data-index="${index}"]`);
      link.href = "https://champschance.s3.us-east-2.amazonaws.com/assets/carousel/" + objectsArray[index].photo;
    });
  })
  .catch((error) => {
    console.error("Error:", error);
  });
*/