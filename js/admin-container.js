// admin-container.js

let dogData;
let carouseldogData;

document.addEventListener("DOMContentLoaded", function() {
  // Get the query parameters from the URL
  const queryString = window.location.search;

  // Initial get of JSON data
  fetchDogs()

  // Check if the query string contains '?edited'
  // If so, force a refresh
  if (queryString.includes('?edited') || queryString.includes('?animaladded') || queryString.includes('?removed') || queryString.includes('?removedimg')) {
    let currentUrl = window.location.href.split('?')[0];
    window.history.replaceState(null, null, currentUrl);
    forceRefreshData();
  }
});

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

function forceRefreshData() {
  console.log("Force Refresh Data!");
  // Clear cached data
  localStorage.removeItem('dogData');
  localStorage.removeItem('lastFetchTimeDogs');
  // Fetch new data
  fetchDogs();
}

// Modified loadJSON function to use local storage
function fetchDogs() {
  if (shouldFetchNewData()) {
    console.log("dogData NOT cached! Getting new cache.");
    let xhr = new XMLHttpRequest();

    xhr.open("GET", "/includes/get-dogs.inc.php", true); // Removed cache-busting to use local storage for caching
    xhr.onreadystatechange = function () {
      if (xhr.readyState === 4 && xhr.status === 200) {
        // Store data and timestamp in local storage
        localStorage.setItem('dogData', xhr.responseText);
        localStorage.setItem('lastFetchTimeDogs', new Date().getTime().toString());
        handleDogsData(xhr.responseText);
      }
    };
    xhr.send(null);
  } else {
    // Use cached data
    console.log("Using cached data.");
    handleDogsData(localStorage.getItem('dogData'));
  }
}

// Call the loadJSON function and create an array of objects from the JSON data
function handleDogsData(response) {
  // Parse the JSON data into a JavaScript object
  dogData = JSON.parse(response);

  drawAdoptCards('');
}

function drawAdoptCards(searchTerm) {
  //CREATE ADOPT CARDS
  const adoptContent = document.querySelector(".adopt-content");
  adoptContent.innerHTML = "";

  for (let i = 0; i < dogData.length; i++) {
    try{
      if (searchTerm === '' || dogData[i].name.toLowerCase().includes(searchTerm)) {
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

        // EDIT MODAL IS A WIP
        // CREATE EDIT MODAL
        const adoptModal = document.createElement("div");
        adoptModal.classList.add("adopt-modal");
        adoptContainer.appendChild(adoptModal);

        const adoptModalBody = document.createElement("div");
        adoptModalBody.classList.add("adopt-modal-body");
        adoptModalBody.setAttribute("id", "adopt-modal-body");
        adoptModal.appendChild(adoptModalBody);

        // modal: close button
        const modalCloseBtn = document.createElement("i");
        modalCloseBtn.classList.add("fas", "fa-times", "modal-close-btn");
        adoptModalBody.appendChild(modalCloseBtn);

        const editDogForm = document.createElement("form");
        editDogForm.action = "../includes/add-animal.inc.php";
        editDogForm.method = "POST";
        editDogForm.name = "editAnimalForm";
        editDogForm.enctype = "multipart/form-data";
        adoptModalBody.appendChild(editDogForm);

        // modal: intro header
        const modalName = document.createElement("input");
        modalName.type = "text";
        modalName.name = "dogName";
        modalName.placeholder = "Dog's name";
        modalName.value = dogData[i].name;
        modalName.required = true;
        editDogForm.appendChild(modalName);

        // #######################################################################################
        // MODAL IMAGES     MODAL IMAGES     MODAL IMAGES     MODAL IMAGES     MODAL IMAGES     
        // #######################################################################################

        // the overarching container
        const dogInfo = document.createElement("div");
        dogInfo.classList.add("dog-edit-info");
        editDogForm.appendChild(dogInfo);

        // the image containers
        const imageContainer1 = document.createElement("div");
        imageContainer1.classList.add("editImage-container");
        dogInfo.appendChild(imageContainer1);

        const imageContainer2 = document.createElement("div");
        imageContainer2.classList.add("editImage-container");
        dogInfo.appendChild(imageContainer2);

        const imageContainer3 = document.createElement("div");
        imageContainer3.classList.add("editImage-container");
        dogInfo.appendChild(imageContainer3);

        // draw existing or null image 1
        const editImage1 = document.createElement("img");
        const editImage1Label = document.createElement("span");
        const ControlsContainer1 = document.createElement("div");

        if (dogData[i].photo !== null) {
          editImage1.src = "https://champschance.s3.us-east-2.amazonaws.com/dog-thumbnails/" + dogData[i].photo;
          editImage1.alt = "Image 1";
          editImage1.classList.add("dogEdit-image");
          editImage1Label.textContent = "Replace image:";
        } else {
          editImage1.src = "https://champschance.s3.us-east-2.amazonaws.com/assets/no-img.png";
          editImage1Label.textContent = "Upload image:";
        }
        imageContainer1.appendChild(editImage1);
        imageContainer1.appendChild(editImage1Label);
        imageContainer1.appendChild(ControlsContainer1);

        // UPLOAD image 1
        const editUploadImg1 = document.createElement("input");
        editUploadImg1.type = "file";
        editUploadImg1.id = imageInput;
        editUploadImg1.name = "editUploadImg1";
        editUploadImg1.accept = "image/jpeg, image/jpg, image/png";
        ControlsContainer1.appendChild(editUploadImg1);


        // draw existing or null image 2
        const editImage2 = document.createElement("img");
        const editImage2Label = document.createElement("span");
        const ControlsContainer2 = document.createElement("div");

        if (dogData[i].photo2 !== null) {
          editImage2.src = "https://champschance.s3.us-east-2.amazonaws.com/dog-thumbnails/" + dogData[i].photo2;
          editImage2.alt = "Image 2";
          editImage2.classList.add("dogEdit-image");
          editImage2Label.textContent = "Replace image:";

        } else {
          editImage2.src = "https://champschance.s3.us-east-2.amazonaws.com/assets/no-img.png";
          editImage2Label.textContent = "Upload image:";
        }
        imageContainer2.appendChild(editImage2);
        imageContainer2.appendChild(editImage2Label);
        imageContainer2.appendChild(ControlsContainer2);

        // UPLOAD image 2
        const editUploadImg2 = document.createElement("input");
        editUploadImg2.type = "file";
        editUploadImg2.id = imageInput;
        editUploadImg2.name = "editUploadImg2";
        editUploadImg2.accept = "image/jpeg, image/jpg, image/png";
        ControlsContainer2.appendChild(editUploadImg2);

        // Create Remove Button 2
        if (dogData[i].photo2 !== null) {
          const removeImgBtn2 = document.createElement("button");
          removeImgBtn2.type = "submit";
          removeImgBtn2.name = "removeImg2";
          removeImgBtn2.textContent = "Remove";
          removeImgBtn2.value = dogData[i].id;
          ControlsContainer2.appendChild(removeImgBtn2);
        }

        // draw existing or null image 3
        const editImage3 = document.createElement("img");
        const editImage3Label = document.createElement("span");
        const ControlsContainer3 = document.createElement("div");

        if (dogData[i].photo3 !== null) {
          editImage3.src = "https://champschance.s3.us-east-2.amazonaws.com/dog-thumbnails/" + dogData[i].photo3;
          editImage3.alt = "Image 3";
          editImage3.classList.add("dogEdit-image");
          editImage3Label.textContent = "Replace image:";

        } else {
          editImage3.src = "https://champschance.s3.us-east-2.amazonaws.com/assets/no-img.png";
          editImage3Label.textContent = "Upload image:";
        }
        imageContainer3.appendChild(editImage3);
        imageContainer3.appendChild(editImage3Label);
        imageContainer3.appendChild(ControlsContainer3);

        // UPLOAD image 3
        const editUploadImg3 = document.createElement("input");
        editUploadImg3.type = "file";
        editUploadImg3.id = imageInput;
        editUploadImg3.name = "editUploadImg3";
        editUploadImg3.accept = "image/jpeg, image/jpg, image/png";
        ControlsContainer3.appendChild(editUploadImg3);

        // Create Remove Button 3
        if (dogData[i].photo3 !== null) {
          const removeImgBtn3 = document.createElement("button");
          removeImgBtn3.type = "submit";
          removeImgBtn3.name = "removeImg3";
          removeImgBtn3.textContent = "Remove";
          removeImgBtn3.value = dogData[i].id;
          ControlsContainer3.appendChild(removeImgBtn3);
        }

        // #######################################################################################
        // MODAL IMAGES     MODAL IMAGES     MODAL IMAGES     MODAL IMAGES     MODAL IMAGES     
        // #######################################################################################

        const modalDescription = document.createElement("textarea");
        modalDescription.name = "dogDescription";
        modalDescription.className = "text";
        modalDescription.rows = "10";
        modalDescription.cols = "30";
        modalDescription.maxLength = "1024";
        modalDescription.required = true;
        modalDescription.value = dogData[i].description;
        editDogForm.appendChild(modalDescription);

        // MODAL: UL SECTION
        const dogStatsList = document.createElement("div");
        dogStatsList.classList.add("dog-stats-list");
        editDogForm.appendChild(dogStatsList);

        const dogStatsUl = document.createElement("ul");
        dogStatsList.appendChild(dogStatsUl);

        const modalStatus = document.createElement("select");
        modalStatus.name = "dogStatus";
        modalStatus.required = true;
        dogStatsUl.appendChild(modalStatus);

        const options = [
          { value: "Available", text: "Available" },
          { value: "Available / In Foster Home", text: "Available / In Foster Home" },
          { value: "On hold / Unavailable", text: "On hold / Unavailable" }
        ];

        for (const option of options) {
          const optionElement = document.createElement("option");
          optionElement.value = option.value;
          optionElement.textContent = option.text;
        
          if (option.text === dogData[i].status) {
            optionElement.selected = true;
          }
        
          modalStatus.appendChild(optionElement);
        }

        // INPUT: BREED
        const dogStatsBreed = document.createElement("input");
        dogStatsBreed.type = "text";
        dogStatsBreed.name = "dogBreed";
        dogStatsBreed.placeholder = "Breed";
        dogStatsBreed.value = dogData[i].breed;
        dogStatsBreed.required = true;
        dogStatsUl.appendChild(dogStatsBreed);

        // INPUT: AGE
        const dogStatsAge = document.createElement("input");
        dogStatsAge.type = "text";
        dogStatsAge.name = "dogAge";
        dogStatsAge.placeholder = "Age";
        dogStatsAge.value = dogData[i].age;
        dogStatsAge.required = true;
        dogStatsUl.appendChild(dogStatsAge);

        // INPUT: COLOR
        const dogStatsColor = document.createElement("input");
        dogStatsColor.type = "text";
        dogStatsColor.name = "dogColor";
        dogStatsColor.placeholder = "Color";
        dogStatsColor.value = dogData[i].color;
        dogStatsAge.required = true;
        dogStatsUl.appendChild(dogStatsColor);

        // INPUT: GENDER
        const dogStatsGender = document.createElement("select");
        dogStatsGender.name = "dogGender";
        dogStatsGender.required = true;

        const optionMale = document.createElement("option");
        optionMale.value = "Male";
        optionMale.textContent = "Male";
        if (dogData[i].gender === "Male") {
          optionMale.selected = true;
        }
        dogStatsGender.appendChild(optionMale);

        const optionFemale = document.createElement("option");
        optionFemale.value = "Female";
        optionFemale.textContent = "Female";
        if (dogData[i].gender === "Female") {
          optionFemale.selected = true;
        }
        dogStatsGender.appendChild(optionFemale);

        dogStatsUl.appendChild(dogStatsGender);


        // INPUT: SIZE
        const dogStatsSize = document.createElement("select");
        dogStatsSize.name = "dogSize";
        dogStatsSize.required = true;

        const sizeOptions = [
          { value: "Small", text: "Small" },
          { value: "Medium", text: "Medium" },
          { value: "Large", text: "Large" }
        ];

        for (const sizeOption of sizeOptions) {
          const optionElement = document.createElement("option");
          optionElement.value = sizeOption.value;
          optionElement.textContent = sizeOption.text;
        
          if (sizeOption.text === dogData[i].size) {
            optionElement.selected = true;
          }
        
          dogStatsSize.appendChild(optionElement);
        }

        dogStatsUl.appendChild(dogStatsSize);

        // INPUT: FEE
        const adoptFee = document.createElement("div");
        adoptFee.classList.add("adopt-fee");
        editDogForm.appendChild(adoptFee);

        const dogAdoptFee = document.createElement("span");
        dogAdoptFee.innerHTML = `Adoption fee: `;
        adoptFee.appendChild(dogAdoptFee);

        const editAdoptFee = document.createElement("input");
        editAdoptFee.type = "text";
        editAdoptFee.name = "dogFee";
        editAdoptFee.placeholder = "Fee";
        editAdoptFee.value = dogData[i].fee;
        editAdoptFee.required = true;
        editDogForm.appendChild(editAdoptFee);

        // INPUT: MEDICAL NEEDS
        const medicalNeedsContainer = document.createElement("div");
        medicalNeedsContainer.classList.add("medical-needs-container");
        editDogForm.appendChild(medicalNeedsContainer);

        const medicalNeedsCheckbox = document.createElement("input");
        medicalNeedsCheckbox.type = "checkbox";
        medicalNeedsCheckbox.name = "dogMedicalNeeds";
        medicalNeedsCheckbox.id = "medicalNeeds";
        medicalNeedsCheckbox.checked = dogData[i].medicalneeds;
        medicalNeedsContainer.appendChild(medicalNeedsCheckbox);

        const medicalNeedsLabel = document.createElement("label");
        medicalNeedsLabel.setAttribute("for", "medicalNeeds");
        medicalNeedsLabel.textContent = "Medical Spotlight?";
        medicalNeedsContainer.appendChild(medicalNeedsLabel);

        // DOG NOTES
        const dogNotes = document.createElement("textarea");
        dogNotes.name = "dogNotes";
        dogNotes.className = "text";
        dogNotes.rows = "4";
        dogNotes.cols = "30";
        dogNotes.maxLength = "512";
        if (dogData[i].notes === null || dogData[i].notes === "") {
          dogNotes.placeholder = "Use this space to write down any administrative notes about " + dogData[i].name + ". This will NOT be publicly seen, is not required, and is only for internal use.";
        }
        else {
          dogNotes.value = dogData[i].notes;
        }
        editDogForm.appendChild(dogNotes);

        // EDIT SUBMIT BUTTONS
        const adoptFormContainer = document.createElement("div");
        adoptFormContainer.classList.add("modify-buttons-container");
        editDogForm.appendChild(adoptFormContainer);

        const editButtonA = document.createElement("a");
        editButtonA.classList.add("adptbtn");
        editButtonA.setAttribute("href", "");
        editButtonA.setAttribute("target", "_blank");
        adoptFormContainer.appendChild(editButtonA);

        const dogEditButton = document.createElement("button");
        dogEditButton.type = "submit";
        dogEditButton.name = "edit";
        dogEditButton.value = dogData[i].id;
        dogEditButton.textContent = "Save Animal";
        editButtonA.appendChild(dogEditButton);

        const deleteButtonA = document.createElement("a");
        deleteButtonA.classList.add("adptbtn");
        deleteButtonA.setAttribute("href", "");
        deleteButtonA.setAttribute("target", "_blank");
        adoptFormContainer.appendChild(deleteButtonA);

        // delete button
        const dogDeleteButton = document.createElement("button");
        dogDeleteButton.type = "submit";
        dogDeleteButton.name = "delete";
        dogDeleteButton.textContent = "Delete Animal";
        dogDeleteButton.value = dogData[i].id;
        dogDeleteButton.classList.add("delete-btn");
        deleteButtonA.appendChild(dogDeleteButton);
      }
    } catch (error) {
      console.error(`Error processing object at index ${i}:`, error);
      console.log('Problematic object details:', dogData[i]);
    }
  }

  initializeModalFunctionality(); // Initialize modal functionality

}

function initializeModalFunctionality() {
  const adoptModals = document.querySelectorAll(".adopt-modal");
  const adoptCards = document.querySelectorAll(".adopt-card");
  const modalCloseBtns = document.querySelectorAll(".modal-close-btn");

  const closeModal = function() {
    adoptModals.forEach((modalView) => {
      modalView.classList.remove("active");
    });
  };

  const modal = function(modalClick) {
    adoptModals[modalClick].classList.add("active");
  };

  adoptCards.forEach((adoptcard, i) => {
    adoptcard.addEventListener("click", () => {
      modal(i);
      //console.log("adoptcard.addEventListener click!");
    });
  });

  modalCloseBtns.forEach((modalCloseBtn) => {
    modalCloseBtn.addEventListener("click", closeModal);
  });

  document.addEventListener("click", (event) => {
    if (!event.target.closest(".adopt-modal-body") && !event.target.closest(".adopt-card")) {
      closeModal();
      //console.log("clicked outside modal");
    }
  });
}

function updateModalElements() {
  adoptModals = document.querySelectorAll(".adopt-modal");
  adoptCards = document.querySelectorAll(".adopt-card");
  //console.log("updateModalElements() function called.");
}

// Add an event listener to the 'Add Animal' button
document.getElementById("addDog").addEventListener("click", toggleAddAnimalContainer);
// Function to handle the button click
function toggleAddAnimalContainer() {
  var button = document.getElementById("addDog");
  var container = document.querySelector(".add-animal-container");

  if (container.style.display === "none") {
      container.style.display = "block";
      button.innerHTML = "<i class=\"fa-solid fa-eye-slash\"></i> Hide Form";
  } else {
      container.style.display = "none";
      button.innerHTML = "<i class=\"fa-solid fa-paw\"></i> Add Dog";
  }
}