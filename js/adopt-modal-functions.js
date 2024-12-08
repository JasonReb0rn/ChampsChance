console.log("adopt_modal-functions.js loaded");


function initializeModalFunctionality() {
    const adoptModals = document.querySelectorAll(".adopt-modal");
    const adoptCards = document.querySelectorAll(".adopt-card");
    const modalCloseBtns = document.querySelectorAll(".modal-close-btn");

    const editAdoptBtn = document.querySelector('.edit-adopt');

    // only add the event listener IF editAdoptBtn exists (this caused much pain)
    if (editAdoptBtn) {
        editAdoptBtn.addEventListener('click', function () {
            window.location.href = 'admin.php';
        });
    }

    // modal functionality
    // close all modals
    var closeModal = function () {
        adoptModals.forEach((modalView) => {
            modalView.classList.remove("active");
        });
    };

    var modal = function (modalClick) {
        adoptModals[modalClick].classList.add("active");
    }

    adoptCards.forEach((adoptcard, i) => {
        adoptcard.addEventListener("click", () => {
            modal(i);
            console.log("adoptcard.addEventListener click!");
        });
    });

    // close modal on clicking X button
    modalCloseBtns.forEach((modalCloseBtn) => {
        modalCloseBtn.addEventListener("click", closeModal);
    });

    // if click outside modal
    document.addEventListener("click", (event) => {
        const isEnlargedImgModal = event.target.closest(".enlarged-img-modal");
        const isModalBody = event.target.closest(".adopt-modal-body");
        const isAdoptCard = event.target.closest(".adopt-card");

        if (!isEnlargedImgModal && !isModalBody && !isAdoptCard) {
            closeModal();
            console.log("clicked outside modal");
        }
    });
}


function updateModalElements() {
    adoptModals = document.querySelectorAll(".adopt-modal");
    adoptCards = document.querySelectorAll(".adopt-card");
  }

