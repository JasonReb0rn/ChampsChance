<footer>
    <div class="footer-container">
        <div class="about-group">
            <a href="/home.php"><h2>Champs Chance</h2></a>
            <p>non-profit animal rescue</p>
            <p>Quincy, FL · Tallahassee, FL</p>
           
        </div>
        <div class="hr"></div>
        <div class="info group">
            <h2>Site Navigation</h2>
            <ul>
                <li><a href="/adopt.php">ADOPT</a></li>
                <li><a href="/foster.php">FOSTER</a></li>
                <li><a href="/blog.php">BLOG</a></li>
                <li><a href="/donate.php">DONATE</a></li>
                <li><a href="/about.php">ABOUT</a></li>
                <li><a href="/contact.php">CONTACT</a></li>
                <?php
                    if (isset($_SESSION["userid"])) {
                        echo "<li><a href=\"/includes\logout.inc.php\">LOG OUT</a></li>";
                    }
                    else {
                        echo "<li><a href=\"/login.php\">SIGN IN</a></li>";
                    }
                ?>
            </ul>
        </div>
        <div class="hr"></div>
        <div class="follow group">
            <h2>Follow Us</h2>
            <ul>
                <li><a href="https://www.facebook.com/profile.php?id=100086388489024"><i class="fab fa-facebook-f"></i></a></li>
                <li><a href="https://www.instagram.com/champschance/"><i class="fab fa-instagram"></i></a></li>
            </ul>
        </div>
    </div>
    <div class="footer-copyright group">
        <p id="current-year"></p>
    </div>

    <script>
        var year = new Date().getFullYear();
        document.getElementById("current-year").textContent = "© " + year + " Champs Chance Inc.";
    </script>

</footer>