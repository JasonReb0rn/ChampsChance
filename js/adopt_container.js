// adopt_container.js

let dogData;

// Add an event listener to the search input field
document.getElementById('search-bar').addEventListener('input', function () {
  const searchTerm = this.value.toLowerCase();
  console.log('Search term:', searchTerm);
  drawAdoptCards(searchTerm);
});

// Helper function to check if data should be fetched
function shouldFetchNewData() {
  const lastFetch = localStorage.getItem('lastFetchTimeDogs');
  if (!lastFetch) {
    return true; // No data has been fetched before
  }
  const now = new Date().getTime();
  const oneHour = 1000 * 60 * 60; // milliseconds in one hour
  return now - parseInt(lastFetch) > oneHour; // Check if last fetch was more than an hour ago
}

// Modified loadJSON function to use local storage
function loadJSON(callback) {
  if (shouldFetchNewData()) {
    console.log("animals.json NOT cached! Getting new cache.");
    let xhr = new XMLHttpRequest();
    xhr.open("GET", "/includes/get-dogs.inc.php", true); // Removed cache-busting to use local storage for caching
    xhr.onreadystatechange = function () {
      if (xhr.readyState === 4 && xhr.status === 200) {
        // Store data and timestamp in local storage
        localStorage.setItem('dogData', xhr.responseText);
        localStorage.setItem('lastFetchTimeDogs', new Date().getTime().toString());
        callback(xhr.responseText);
      }
    };
    xhr.send(null);
  } else {
    // Use cached data
    callback(localStorage.getItem('dogData'));
    console.log("Using cached data.");
  }
}

// Call the loadJSON function and create an array of objects from the JSON data
loadJSON(function(response) {
  // Parse the JSON data into a JavaScript object
  dogData = JSON.parse(response);

  // Randomize the order of the dogData so that the order of the animals is random
  for (let i = dogData.length - 1; i > 0; i--) {
    const j = Math.floor(Math.random() * (i + 1));
    [dogData[i], dogData[j]] = [dogData[j], dogData[i]];
  }

  drawAdoptCards('');
})

function drawAdoptCards(searchTerm) {
  //CREATE ADOPT CARDS
  const adoptContent = document.querySelector(".adopt-content");
  adoptContent.innerHTML = "";
  // TODO
  // HERE!!!! INSTEAD of dogData.length, something... Find name? check name?
  for (let i = 0; i < dogData.length; i++) {
    if (searchTerm === '' || dogData[i].name.toLowerCase().includes(searchTerm)) {
      if (dogData[i].status != "On hold / Unavailable") {
        const adoptContainer = document.createElement("div");
        adoptContainer.classList.add("adopt-container");
        adoptContent.appendChild(adoptContainer);

        const adoptCard = document.createElement("div");
        adoptCard.classList.add("adopt-card");
        adoptContainer.appendChild(adoptCard);

        const adoptOverlay = document.createElement("div");
        adoptOverlay.classList.add("adopt-overlay");
        adoptCard.appendChild(adoptOverlay);

        const cardInfo = document.createElement("div");
        cardInfo.classList.add("info");
        adoptCard.appendChild(cardInfo);

        const name = document.createElement("h3");
        name.textContent = dogData[i].name;
        cardInfo.appendChild(name);

        const img = document.createElement("img");
        img.src = "https://champschance.s3.us-east-2.amazonaws.com/dog-thumbnails/" + dogData[i].photo;
        img.alt = dogData[i].name;
        adoptCard.appendChild(img);



        // CREATE MODAL
        const adoptModal = document.createElement("div");
        adoptModal.classList.add("adopt-modal");
        adoptContainer.appendChild(adoptModal);

        const adoptModalBody = document.createElement("div");
        adoptModalBody.classList.add("adopt-modal-body");
        adoptModalBody.setAttribute("id", "adopt-modal-body");
        adoptModal.appendChild(adoptModalBody);

        //modal: close button
        const modalCloseBtn = document.createElement("i");
        modalCloseBtn.classList.add("fas", "fa-times", "modal-close-btn");
        adoptModalBody.appendChild(modalCloseBtn);

        //modal: intro header
        const modalName = document.createElement("h3");
        modalName.textContent = dogData[i].name;
        adoptModalBody.appendChild(modalName);

        const dogInfo = document.createElement("div");
        dogInfo.classList.add("dog-info");
        adoptModalBody.appendChild(dogInfo);

        const adoptImagesContainer = document.createElement("div");
        adoptImagesContainer.classList.add("adopt-images-container");
        dogInfo.appendChild(adoptImagesContainer);

        const createImageElement = (src, alt) => {
          const img = document.createElement("img");
          img.src = src;
          img.alt = alt;
          return img;
        };

        // CREATE MODAL IMAGE 1
        const modalImg1 = createImageElement("https://champschance.s3.us-east-2.amazonaws.com/dog-thumbnails/" + dogData[i].photo, dogData[i].name);
        adoptImagesContainer.appendChild(modalImg1);

        // Add event listener to open modal on clicking modalImg1
        modalImg1.addEventListener("click", function () {
          console.log("Clicked Image 1");
          openImageModal("https://champschance.s3.us-east-2.amazonaws.com/dogs/" + dogData[i].photo, dogData[i].name);
        });

        if (dogData[i].photo2 !== null) {
          const modalImg2 = createImageElement("https://champschance.s3.us-east-2.amazonaws.com/dog-thumbnails/" + dogData[i].photo2, dogData[i].name);
          adoptImagesContainer.appendChild(modalImg2);
        
          // Add event listener to open modal on clicking modalImg2
          modalImg2.addEventListener("click", function () {
              console.log("Clicked Image 2");
              openImageModal("https://champschance.s3.us-east-2.amazonaws.com/dogs/" + dogData[i].photo2, dogData[i].name);
          });
        }

        if (dogData[i].photo3 !== null) {
          const modalImg3 = createImageElement("https://champschance.s3.us-east-2.amazonaws.com/dog-thumbnails/" + dogData[i].photo3, dogData[i].name);
          adoptImagesContainer.appendChild(modalImg3);
        
          // Add event listener to open modal on clicking modalImg3
          modalImg3.addEventListener("click", function () {
              console.log("Clicked Image 3");
              openImageModal("https://champschance.s3.us-east-2.amazonaws.com/dogs/" + dogData[i].photo3, dogData[i].name);
          });
        }


        const modalDesc = document.createElement("span");
        modalDesc.classList.add("modalDescription");
        modalDesc.textContent = dogData[i].description;
        dogInfo.appendChild(modalDesc);

        //modal: dog stats list
        const dogStatsList = document.createElement("div");
        dogStatsList.classList.add("dog-stats-list");
        adoptModalBody.appendChild(dogStatsList);

        const dogStatsUl = document.createElement("ul");
        dogStatsList.appendChild(dogStatsUl);

        const dogStatsStatus = document.createElement("li");
        dogStatsStatus.innerHTML = `Status: <span>${dogData[i].status}</span>`;
        dogStatsUl.appendChild(dogStatsStatus);

        const dogStatsBreed = document.createElement("li");
        dogStatsBreed.innerHTML = `Breed: <span>${dogData[i].breed}</span>`;
        dogStatsUl.appendChild(dogStatsBreed);

        const dogStatsAge = document.createElement("li");
        dogStatsAge.innerHTML = `Age: <span>${dogData[i].age}</span>`;
        dogStatsUl.appendChild(dogStatsAge);

        const dogStatsColor = document.createElement("li");
        dogStatsColor.innerHTML = `Color: <span>${dogData[i].color}</span>`;
        dogStatsUl.appendChild(dogStatsColor);

        const dogStatsGender = document.createElement("li");
        dogStatsGender.innerHTML = `Gender: <span>${dogData[i].gender}</span>`;
        dogStatsUl.appendChild(dogStatsGender);

        const dogStatsSize = document.createElement("li");
        dogStatsSize.innerHTML = `Size: <span>${dogData[i].size}</span>`;
        dogStatsUl.appendChild(dogStatsSize);

        const adoptFee = document.createElement("div");
        adoptFee.classList.add("adopt-fee");
        adoptModalBody.appendChild(adoptFee);

        const dogAdoptFee = document.createElement("span");
        dogAdoptFee.classList.add("modalAdoptFee");
        dogAdoptFee.innerHTML = `Adoption fee: ${dogData[i].fee}`;
        adoptFee.appendChild(dogAdoptFee);

        if (dogData[i].medicalneeds === true) {
          const medicalNeedsContainer = document.createElement("div");
          medicalNeedsContainer.classList.add("medical-needs-container");
          adoptModalBody.appendChild(medicalNeedsContainer);
        
          const medicalNeedsButton = document.createElement("button");
          medicalNeedsButton.classList.add("medical-needs-button");
          medicalNeedsContainer.appendChild(medicalNeedsButton);
        
          const dogMedicalIcon = document.createElement("i");
          dogMedicalIcon.classList.add("fa-solid", "fa-heart");
          medicalNeedsButton.appendChild(dogMedicalIcon);
        
          const dogMedicalNeeds = document.createElement("span");
          dogMedicalNeeds.innerHTML = `Medical Spotlight`;
          medicalNeedsButton.appendChild(dogMedicalNeeds);
        
          // Add event listener to redirect when the button is clicked
          medicalNeedsButton.addEventListener("click", function () {
            window.location.href = "../medical_spotlight.php";
          });
        }

        const adoptFormContainer = document.createElement("div");
        adoptFormContainer.classList.add("adopt-form-container");
        adoptModalBody.appendChild(adoptFormContainer);

        const adoptButtonA = document.createElement("a");
        adoptButtonA.classList.add("adptbtn");
        adoptButtonA.setAttribute("href", "https://www.cognitoforms.com/ChampsChanceInc1/ChampsChanceIncApplication");
        adoptButtonA.setAttribute("target", "_blank");
        adoptFormContainer.appendChild(adoptButtonA);

        const adoptButton = document.createElement("button");
        adoptButton.textContent = "Apply to Adopt";
        adoptButtonA.appendChild(adoptButton);
      }
    }
  }

  initializeModalFunctionality();
}

function openImageModal(src, alt) {
  // Define createImageElement locally
  const createImageElement = (src, alt) => {
      const img = document.createElement("img");
      img.src = src;
      img.alt = alt;
      return img;
  };

  const enlargedImgModal = document.createElement("div");
  enlargedImgModal.classList.add("enlarged-img-modal");

  const enlargedImg = createImageElement(src, alt);
  enlargedImgModal.appendChild(enlargedImg);

  // Append the modal to the body
  document.body.appendChild(enlargedImgModal);

  // Add event listener to close modal on clicking the enlarged image
  enlargedImg.addEventListener("click", function (event) {
      // Prevent the click event from propagating to the parent modal
      event.stopPropagation();
      document.body.removeChild(enlargedImgModal);
  });
}