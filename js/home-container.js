console.log("home-container.js loaded");

let jsonData;
let randomDogData = [];

const xhttp = new XMLHttpRequest();

function createAdoptCards() {
    const adoptContent = document.querySelector(".featured-dogs");
    adoptContent.innerHTML = ""; // Clear previous content

    // Loop through the randomObjects array
    for (let i = 0; i < randomDogData.length; i++) {
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
    name.textContent = randomDogData[i].name;
    cardInfo.appendChild(name);

    const img = document.createElement("img");
    img.src = "https://champschance.s3.us-east-2.amazonaws.com/dog-thumbnails/" + randomDogData[i].photo;
    img.alt = randomDogData[i].name;
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
    modalName.textContent = randomDogData[i].name;
    adoptModalBody.appendChild(modalName);

    const dogInfo = document.createElement("div");
    dogInfo.classList.add("dog-info");
    adoptModalBody.appendChild(dogInfo);

    const modalImg = document.createElement("img");
    modalImg.src = "https://champschance.s3.us-east-2.amazonaws.com/dog-thumbnails/" + randomDogData[i].photo;
    modalImg.alt = randomDogData[i].name;
    dogInfo.appendChild(modalImg);

    const modalDesc = document.createElement("span");
    modalDesc.textContent = randomDogData[i].desc;
    dogInfo.appendChild(modalDesc);

    //modal: dog stats list
    const dogStatsList = document.createElement("div");
    dogStatsList.classList.add("dog-stats-list");
    adoptModalBody.appendChild(dogStatsList);

    const dogStatsUl = document.createElement("ul");
    dogStatsList.appendChild(dogStatsUl);

    const dogStatsStatus = document.createElement("li");
    dogStatsStatus.innerHTML = `Status: <span>${randomDogData[i].status}</span>`;
    dogStatsUl.appendChild(dogStatsStatus);
    
    const dogStatsBreed = document.createElement("li");
    dogStatsBreed.innerHTML = `Breed: <span>${randomDogData[i].breed}</span>`;
    dogStatsUl.appendChild(dogStatsBreed);

    const dogStatsAge = document.createElement("li");
    dogStatsAge.innerHTML = `Age: <span>${randomDogData[i].age}</span>`;
    dogStatsUl.appendChild(dogStatsAge);

    const dogStatsColor = document.createElement("li");
    dogStatsColor.innerHTML = `Color: <span>${randomDogData[i].color}</span>`;
    dogStatsUl.appendChild(dogStatsColor);

    const dogStatsGender = document.createElement("li");
    dogStatsGender.innerHTML = `Gender: <span>${randomDogData[i].gender}</span>`;
    dogStatsUl.appendChild(dogStatsGender);

    const dogStatsSize = document.createElement("li");
    dogStatsSize.innerHTML = `Size: <span>${randomDogData[i].size}</span>`;
    dogStatsUl.appendChild(dogStatsSize);

    const adoptFee = document.createElement("div");
    adoptFee.classList.add("adopt-fee");
    adoptModalBody.appendChild(adoptFee);

    const dogAdoptFee = document.createElement("span");
    dogAdoptFee.innerHTML = `Adoption fee: ${randomDogData[i].fee}`;
    adoptFee.appendChild(dogAdoptFee);

    if (randomDogData[i].medicalneeds === true) {
      const medicalNeedsContainer = document.createElement("div");
      medicalNeedsContainer.classList.add("medical-needs-container");
      adoptModalBody.appendChild(medicalNeedsContainer);

      const medicalNeedsDiv = document.createElement("div");
      medicalNeedsDiv.classList.add("medical-needs");
      medicalNeedsContainer.appendChild(medicalNeedsDiv);

      const dogMedicalIcon = document.createElement("i");
      dogMedicalIcon.classList.add("fa-solid", "fa-heart")
      medicalNeedsDiv.appendChild(dogMedicalIcon);
  
      const dogMedicalNeeds = document.createElement("span");
      dogMedicalNeeds.innerHTML = `Medical Spotlight`;
      medicalNeedsDiv.appendChild(dogMedicalNeeds);
    
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

  // set up all the event listeners and such for adopt card modal
function initializeModalFunctionality() {
  const adoptModals = document.querySelectorAll(".adopt-modal");
  const adoptCards = document.querySelectorAll(".adopt-card");
  const modalCloseBtns = document.querySelectorAll(".modal-close-btn");
  const deleteAnimalBtns = document.querySelectorAll(".fa-trash");

  // modal functionality
  // close all modals
  var closeModal = function() {
      adoptModals.forEach((modalView) => {
          modalView.classList.remove("active");
      });
  };

  //
  var modal = function(modalClick){
      adoptModals[modalClick].classList.add("active");
  }

  // CLICKED AN ADOPT CARD
  adoptCards.forEach((adoptcard, i) => {
    adoptcard.addEventListener("click", () => {
        modal(i);
        console.log("adoptcard.addEventListener click!");
    });
  });


  //close modal on clicking X button
  modalCloseBtns.forEach((modalCloseBtn) => {
      modalCloseBtn.addEventListener("click", closeModal);
  });

  //if click outside modal
  document.addEventListener("click", (event) => {
      if (!event.target.closest(".adopt-modal-body") && !event.target.closest(".adopt-card")) {
          closeModal();
          console.log("clicked outside modal");
      }
  });
}

function updateModalElements() {
    adoptModals = document.querySelectorAll(".adopt-modal");
    adoptCards = document.querySelectorAll(".adopt-card");
    console.log("updateModalElements() function called.");
}

function updateAdoptCards() {
    let xhr = new XMLHttpRequest();
    xhr.open('GET', '/includes/get-4-random-dogs.inc.php', true);
    xhr.onreadystatechange = function () {
      if (xhr.readyState === 4 && xhr.status === 200) {
        randomDogData = JSON.parse(xhr.responseText);

        console.log("updateRandomDogs");
        createAdoptCards();
        initializeModalFunctionality();
      }
    };
    xhr.send(null);
}
  
// Call the updateAdoptCards function to create the initial adopt cards
updateAdoptCards();
  
