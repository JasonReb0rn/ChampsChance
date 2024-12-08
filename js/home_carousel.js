
window.onload = function() {
    var questions = document.getElementsByClassName("question");
  
    for (var i = 0; i < questions.length; i++) {
      questions[i].onclick = function() {
        var answer = this.nextElementSibling;
        var activeQuestion = document.querySelector(".question.active");
  
        // Close any open answer before opening a new one
        if (activeQuestion && activeQuestion !== this) {
          var activeAnswer = activeQuestion.nextElementSibling;
          activeQuestion.classList.remove("active");
          activeAnswer.style.display = "none";
        }
  
        // Toggle the clicked answer
        if (answer.style.display === "block") {
          this.classList.remove("active");
          answer.style.display = "none";
        } else {
          this.classList.add("active");
          answer.style.display = "block";
        }
      };
    }
  };
  