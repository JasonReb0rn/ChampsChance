<header>
    <div class="nav-logo-mobile-hamburger-div">
        <a href="/home.php">
            <img class="logo" src="https://champschance.s3.us-east-2.amazonaws.com/assets/logo.png" alt="logo">
        </a>

        <div class="mobile_menu_btn_div">
            <i class="fa-solid fa-bars" id="Hamburger"></i>
        </div>
    </div>

    
    <?php if (isset($_SESSION["userid"])): ?>
        <nav class="nav-class" style="margin-left:auto;">
    <?php else: ?>
        <nav class="nav-class">
    <?php endif; ?>
        <ul class="nav__links">

            <li class="dropdown-menu">
                <a href="/donate.php"><button class="donate-header-btn">DONATE <i class="fa-solid fa-heart"></i></button></a>
                <div class="dropdown-content donate-dropdown-content">
                    <a href="/dedicated-donations.php">DEDICATED DONATIONS</a>
                </div>
            </li>

            <!--<li><a href="/donate.php"><button class="donate-header-btn">DONATE <i class="fa-solid fa-heart"></i></button></a></li>-->
            <li><a href="/adopt.php"><button>ADOPT</button></a></li>
            <li><a href="/foster.php"><button>FOSTER</button></a></li>
            <li><a href="/blog.php"><button>BLOG</button></a></li>
            <li><a href="/about.php"><button>ABOUT</button></a></li>
            <li class="dropdown-menu">
                <button class="dropbtn">MORE</button>
                <div class="dropdown-content">
                    <a href="/volunteer.php">VOLUNTEER</a>
                    <a href="/medical_spotlight.php">MEDICAL SPOTLIGHT</a>
                    <a href="/contact.php">CONTACT</a>
                </div>
            </li>
        </ul>
    </nav>

    <?php
    if (isset($_SESSION["userid"])) {
        echo "<div class=\"user-welcome-container\">
                  <div class=\"welcome-message-div\">
                      <span class=\"welcome-message\">Welcome, " . $_SESSION["useruid"] . "! 🐶</span>
                  </div>
                  <div class=\"user-header-img-div\">
                      <img src=\"https://champschance.s3.us-east-2.amazonaws.com/assets/avatars/" . $_SESSION["userAvatar"] . "\" alt=\"User Profile Picture\" class=\"user-header-img\" id=\"user-header-img\">
                      <div class=\"user-header-info-container\">
                        <span class=\"welcome-message\">" . $_SESSION["useruid"] . "</span>
                        <a href=\"/profile.php\"><i class=\"fa-solid fa-user\"></i>Profile</a>
                        <a href=\"/includes\logout.inc.php\"><i class=\"fa-solid fa-right-from-bracket\"></i>Log Out</a>
                      </div>
                  </div>
              </div>";
    } else {
        echo "<a class=\"cta\" href=\"/login.php\"><button>SIGN IN</button></a>";
    }
    ?>
</header>

<!-- Breadcrumbs HTML -->
<div class="breadcrumbs-container">
    <ul class="breadcrumbs" id="breadcrumbs">
      <li><a href="/home.php" class="home-breadcrumb"><i class="fa-solid fa-house"></i></a></li>
      <li id="breadcrumbs-category"><a href="#"></a></li>
      <li id="breadcrumbs-page"></li>
    </ul>
</div>

<script>
  // Get the "MORE" button and the dropdown menu
  const dropdownBtn = document.querySelector(".dropbtn");
  const dropdownContent = document.querySelector(".dropdown-content");

  // Toggle the visibility of the dropdown menu when the "MORE" button is clicked or touched
  const toggleDropdown = () => {
    dropdownContent.classList.toggle("show");
    if (dropdownContent.classList.contains("show")) {
        dropdownContent.classList.remove("show");
      }
  };
  dropdownBtn.addEventListener("click", toggleDropdown);

  // Hide the dropdown menu if the user clicks or touches outside of it
  window.addEventListener("click", (event) => {
    if (!event.target.matches(".dropbtn") && !event.target.matches(".dropdown-content")) {
      if (dropdownContent.classList.contains("show")) {
        dropdownContent.classList.remove("show");
      }
    }
  });

  // For MOBILE nav menu
  // Function to toggle display of navigation links
  function toggleNavLinks() {
    const navLinks = document.querySelector('.nav__links');
    const userWelcome = document.querySelector('.user-welcome-container');
    const contactBtn = document.querySelector('.cta');
    const hamburger = document.getElementById('Hamburger');
  
    if (navLinks.classList.contains('show')) {
        // Hide menu items
        navLinks.classList.remove('show');
        if (userWelcome) userWelcome.classList.remove('show');
        contactBtn.classList.remove('show');
        // Hamburger Button
        hamburger.style.color = '#242424';
        hamburger.style.background = 'white';
        // Change hamburger class
        hamburger.className = 'fa-solid fa-bars';
    } else {
        // Show menu items
        navLinks.classList.add('show');
        if (userWelcome) userWelcome.classList.add('show');
        contactBtn.classList.add('show');
        // Hamburger Button
        hamburger.style.color = 'white';
        hamburger.style.background = '#242424';
        // Change hamburger class
        hamburger.className = 'fa-solid fa-xmark';
    }
  }
  
  // Adding click event listener to the hamburger menu
  const iconElement = document.querySelector('.mobile_menu_btn_div i');
  iconElement.addEventListener('click', toggleNavLinks);
</script>


