<?php
  // Set session cookie parameters to make it accessible across all directories
  session_set_cookie_params(0, '/');
  session_start();
?>

<!DOCTYPE html>
<html lang="en">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<head>
    <title>Champs Chance - North Florida Dog Rescue</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="node_modules/@glidejs/glide/dist/css/glide.core.min.css">
    <link rel="stylesheet" href="node_modules/@glidejs/glide/dist/css/glide.theme.min.css">
    <link rel="stylesheet" href="style.css?v=05282024">
    <link rel="icon" type="image/png" href="https://champschance.s3.us-east-2.amazonaws.com/assets/favicon.png">
    <link rel="icon" type="image/png" href="https://champschance.s3.us-east-2.amazonaws.com/assets/favicon-16.png" sizes="16x16">
    <link rel="icon" type="image/png" href="https://champschance.s3.us-east-2.amazonaws.com/assets/favicon-32.png" sizes="32x32">
    <link rel="icon" type="image/png" href="https://champschance.s3.us-east-2.amazonaws.com/assets/favicon-48.png" sizes="48x48">
    <link rel="icon" type="image/png" href="https://champschance.s3.us-east-2.amazonaws.com/assets/favicon-64.png" sizes="64x64">
    <link rel="icon" type="image/png" href="https://champschance.s3.us-east-2.amazonaws.com/assets/favicon-128.png" sizes="128x128">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
</head>

<body>
    
    <?php
        include_once 'header.php';
    ?>
    <script src="js/breadcrumbs.js"></script>

    <div class="splash-container">
        <div class="splash-pic-left"><img src="https://champschance.s3.us-east-2.amazonaws.com/assets/header/header1.jpg" alt=""></div>
        <div class="splash-pic-middle"><img src="https://champschance.s3.us-east-2.amazonaws.com/assets/header/header2.jpg" alt=""></div>
        <div class="splash-pic-right"><img src="https://champschance.s3.us-east-2.amazonaws.com/assets/header/header3.jpg" alt=""></div>
    </div>

    <div class="main-content">
      <div class="content-container-solid">
        <div class="about-homescreen">
            <h3>We are Champs Chance Inc</h3>
            <p>We were founded with the goal to help dogs with the greatest need. Dogs are often turned away from rescues or euthanized in shelters if they require too much care or medical attention. Through advocating, rehabilitating, and adoption, Champs Chance Inc aims to fill this gap in the region.</p>
        </div>

        <div class="see-dogs-btn-container">
          <button class="see-dogs-carousel-btn" onclick="location.href='/adopt.php'"><i class="fa-solid fa-paw"></i>See our dogs now!</button>
        </div>
      </div>

        <div class="content-block-flex-container">
          <div class="content-block-flex-photo">
            <img src="https://champschance.s3.us-east-2.amazonaws.com/assets/cc_map.png" alt="Champs Chance Map">
          </div>

          <div class="content-block-flex-content">
            <h3>A North Florida Dog Rescue</h3>
            <p>Based in Quincy, Florida, located just outside the bustling captial city of Tallahassee, our rescue proudly serves North Florida communities with compassion and dedication.</p>
            <br>
            <p>Please take a look at the dogs we currently have in our care; if any stand out to you, <i>please</i> reach out to inquire.</p>
          </div>
        </div>

        <div class="content-container-solid">
          <div class="content-block-flex-container" id="rev">
            <div class="content-block-flex-content">
              <h3>Our Story</h3>
              <p>Champ's Chance began with a heart-wrenching journey when Alicia, our founder, faced the limitations of existing rescues in saving dogs like Champ. Determined to make a difference, she broke free to create a haven where every dog, regardless of their medical needs, could find love and care.</p>
              <br>
              <p>Inspired by the indomitable spirit of Champ and Chance, we stand as a beacon of hope for dogs deemed unworthy of rescue. Their legacy fuels our mission to provide every dog with the chance they deserve, nurturing them back to health and happiness.</p>
            </div>
            <div class="content-block-flex-photo">
              <img src="https://champschance.s3.us-east-2.amazonaws.com/assets/alicia.png" alt="Champs Chance Story">
              <div class="img-quote-container">
                <p>"Champ was the reason behind it all. When I couldn't give him the resources he needed to save him, it changed me." -Alicia</p>
              </div>
            </div>
          </div>

          <div class="social-homescreen-container">
              <h2>Follow us on</h2>
              <div class="social-homescreen-grid">
                <div class="home-social-fb">
                  <button onclick="redirectTo('https://www.facebook.com/profile.php?id=100086388489024')" target="_blank"><i class="fab fa-facebook-f"></i>Facebook</button>
                </div>
                <div class="home-social-ig">
                  <button onclick="redirectTo('https://www.instagram.com/champschance/')" target="_blank"><i class="fab fa-instagram"></i>Instagram</button>
                </div>
                <div class="home-social-tk">
                  <button onclick="redirectTo('https://www.tiktok.com/@champschance')" target="_blank"><i class="fa-brands fa-tiktok"></i>Tiktok</button>
                </div>
              </div>
          </div>
        </div>

        

        <script>
          function redirectTo(url) {
            window.open(url, '_blank');
          }
        </script>


        <!--
        <div class="divider">
            <img src="img/pawprint_divider.png" alt="super cute pawprint divider">
        </div>
        -->
        

        <div class="glide">
          <div class="glide__track" data-glide-el="track">
            <ul class="glide__slides">
              <li class="glide__slide">
                <a data-index="0" id="carousel-link-1" href="/home.php" target="_blank">
                  <img data-index="0" class="carousel-img" id="carousel-img-1" src="https://champschance.s3.us-east-2.amazonaws.com/assets/carousel/image-1.jpg" alt="carousel photo 1">
                </a>
              </li>
              <li class="glide__slide">
                <a data-index="1" id="carousel-link-2" href="/home.php" target="_blank">
                  <img data-index="1" class="carousel-img" id="carousel-img-2" src="https://champschance.s3.us-east-2.amazonaws.com/assets/carousel/image-2.jpg" alt="carousel photo 2">
                </a>
              </li>
              <li class="glide__slide">
                <a data-index="2" id="carousel-link-3" href="/home.php" target="_blank">
                  <img data-index="2" class="carousel-img" id="carousel-img-3" src="https://champschance.s3.us-east-2.amazonaws.com/assets/carousel/image-3.jpg" alt="carousel photo 3">
                </a>
              </li>
            </ul>
          </div>


          <div class="glide__bullets" data-glide-el="controls[nav]">
            <button class="glide__bullet" data-glide-dir="=0"></button>
            <button class="glide__bullet" data-glide-dir="=1"></button>
            <button class="glide__bullet" data-glide-dir="=2"></button>
          </div>

          <div class="glide__arrows" data-glide-el="controls">
            <button class="glide__arrow glide__arrow--left" data-glide-dir="<"><i class="fa-solid fa-angle-left"></i></button>
            <button class="glide__arrow glide__arrow--right" data-glide-dir=">"><i class="fa-solid fa-angle-right"></i></button>
          </div>
        
        </div>

        <div class="carousel-edit-btn-container">
          <?php
            if (isset($_SESSION["usersperm"]) && $_SESSION["usersperm"] == 1) {
              echo '<button class="edit-carousel-btn" onclick="location.href=\'/admin.php\'"><i class="fa-solid fa-images"></i>Edit Carousel Images</button>';
            }
            else {

            }
          ?>
        </div>

        <script src="node_modules/@glidejs/glide/dist/glide.min.js"></script>
        <script>

          let ul = document.querySelector('.glide__slides');
          let card = '';
          var glide = new Glide('.glide', {
            autoplay: 5000,
            hoverpause: true,
            type: 'carousel',
            focusAt: 'center',
            perView: 1
          });


          // Fetch image locations from the PHP endpoint
          fetch('/includes/get-carousel-data.inc.php')
            .then(response => response.json())
            .then(data => {
              data.forEach((imageData, index) => {
                // Append image location to the base URL
                const imageUrl = `https://champschance.s3.us-east-2.amazonaws.com/assets/carousel/${imageData.image_name}`;
                const imageLink = `${imageData.image_link}`;
              
                // Create li element for Glide
                card += `<li class="glide__slide"><img class="carousel-img"><a data-index='${index}' id="carousel-link-${index}" href="${imageUrl}" target="_blank"><img data-index="${index}" class="carousel-img" id="carousel-img-${index}" src="${imageUrl}" alt="Image ${index + 1}"></a></li>`;
                // card += `<li class="glide__slide"><img class="carousel-img" src="${imageUrl}" alt="Image ${index + 1}"></li>`;
              });
            
              // Update the innerHTML of the ul element
              ul.innerHTML = card;
            
              // Mount Glide after updating the DOM
              glide.mount();
            })
            .catch(error => console.error('Error fetching carousel data:', error));
        


        </script>

        <div class="content-container-solid">
          <div class="cal-container">
            <div class="cal-link">
              <a class="calbtn" href="https://teamup.com/ks493jxfnxfyraq7ze" target="_blank"><img src="https://champschance.s3.us-east-2.amazonaws.com/assets/calendar.png" alt="Calander"></a>
            </div>
            <div class="cal-header">
              <h3>Event Calendar</h3>
              <p>Click the calendar to see a list of all of our events that we'll be at! Stop by to see some of our lovely dogs in person, talk about the adoption process, or even just support us by showing up.</p>
              <br>
              <p>We can also <i>always</i> use help, check out the <a href="/volunteer.php">Volunteer Page</a> for more information.</p>
            </div>
            
          </div>

          <div class="featured-dogs-container">
              <h3>Featured Dogs</h3>
              <p>Discover four new random dogs from our database every time you refresh the page.</p>
              <div class="featured-dogs">

              </div>
              <a class="adptbtn" href="adopt.php"><button>Click Here To See Them All!</button></a>
          </div>
        </div>

        

        <div class="faq-container">
            <h3>Frequently Asked Questions</h3>
            <div class="faq-question">
              <div class="question">
                <div class="question-text">What makes you different from other rescues in the area?</div>
                <div class="caret-down"><i class="fa-solid fa-angle-down"></i></div>
            </div>
              <div class="answer">We were founded specifically to help dogs with special medical needs. Many other rescues try to stretch their dollars as far as possible to help as many dogs as they can, which often times means turning away or euthanizing dogs who need extensive care. Even though our funds are also limited, we were founded with the goal to fill this gap and help these extra vulnerable dogs. Of course, we also help dogs without special medical needs, too. This is why no donation is too small and every dollar counts!</div>
            </div>
            <div class="faq-question">
              <div class="question">
                <div class="question-text">Is your staff paid?</div>
                <div class="caret-down"><i class="fa-solid fa-angle-down"></i></div>
              </div>
              <div class="answer">Nope! Our staff is made up entirely of volunteers in the community. We currently have a very small volunteer base and desperately need more help, please inquire if you are interested in learning more about how to help!</div>
            </div>
            <div class="faq-question">
              <div class="question">
                <div class="question-text">How do you receive your funding?</div>
                <div class="caret-down"><i class="fa-solid fa-angle-down"></i></div>
              </div>
              <div class="answer">We receive all of our funding from fundraisers, events, and generous community donations. Our founder, Alicia, pays for much of the costs herself (with currently maxed-out credit cards). Please consider donating. All funds go directly to the care of the dogs!</div>
            </div>
            <div class="faq-question">
              <div class="question">
                <div class="question-text">Where do your dogs come from?</div>
                <div class="caret-down"><i class="fa-solid fa-angle-down"></i></div>
              </div>
              <div class="answer">Our dogs come from a variety of places. Many are from off the streets as strays, some are pulled from over-crowded rural shelters, and others are transferred from other states that are at risk of euthanasia. Each dog has a unique story, and unfortunately most of them have yet to experience the luxury of a happy and safe home.</div>
            </div>
            <div class="faq-question">
              <div class="question">
                <div class="question-text">Why are there ads on the website?</div>
                <div class="caret-down"><i class="fa-solid fa-angle-down"></i></div>
              </div>
              <div class="answer">We understand the curiosity! Running our website comes with a monthly cost, and while the ads do help, they don't quite cover it all. Your support, whether it's through website engagement or contributing directly, goes a long way in keeping us up and running to help more dogs find loving homes in Quincy and Tallahassee!</div>
            </div>
        </div>

        <script>
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
        </script>


    </div>
    
    <?php
        include_once 'footer.php';
    ?>

        
    </div>
</body>
</html>


<script src="js/home-container.js"></script>