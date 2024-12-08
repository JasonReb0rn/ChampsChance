const signinForm = document.querySelector(".signin-form");
const signupForm = document.querySelector(".signup-form");
const forgotForm = document.querySelector(".forgot-form");
const signinBtn = document.querySelector(".signin-btn label");
const signupBtn = document.querySelector(".signup-btn label");
const forgotBtn = document.querySelector(".forgot-btn");

function signIn() {
  signinForm.classList.add("active");
  signupForm.classList.remove("active");
  forgotForm.classList.remove("active");
  signinBtn.classList.add("active");
  signupBtn.classList.remove("active");
}

function register() {
  signinForm.classList.remove("active");
  forgotForm.classList.remove("active");
  signupForm.classList.add("active");
  signinBtn.classList.remove("active");
  signupBtn.classList.add("active");
}

function forgot() {
  signinForm.classList.remove("active");
  signupForm.classList.remove("active");
  forgotForm.classList.add("active");
  signinBtn.classList.remove("active");
  signupBtn.classList.remove("active");
}

document.querySelector('.signin-btn label').addEventListener('click', signIn);
document.querySelector('.signup-btn label').addEventListener('click', register);
forgotBtn.addEventListener('click', forgot);

document.addEventListener("DOMContentLoaded", function() {
  const urlParams = new URLSearchParams(window.location.search);
  const registerError = urlParams.get('register-error');
  const forgotError = urlParams.get('forgot-error');

  if (registerError) {
    register(); // Call register function if there's an error or success message in the URL
  } 
  else if (forgotError) {
    forgot();
  }
  else {
    signIn(); // Call signIn function by default
  }
});

