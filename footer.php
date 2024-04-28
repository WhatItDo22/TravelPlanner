<footer class="footer__container">
    <p id="footer__id">ItineraEase Group:</p>
    <div class="footer__links">
        <div class="footer__link--wrapper">
            <div class="footer__link--items">
                <p><strong>Company</strong></p>
                <a href="#">About</a>
                <a href="#">Jobs</a>
                <a href="#">Partnerships</a>
                <a href="#">Newsroom</a>
                <a href="#">Advertising</a>
                <a href="#">Feedback</a>
            </div>
            <div class="footer__link--items">
                <p><strong>Explore</strong></p>
                <a href="#">Hotels in United States of America</a>
                <a href="#">United States of America travel guide</a>
                <a href="#">Domestic Flights</a>
            </div>
            <div class="footer__link--items">
                <p><strong>Policies</strong></p>
                <a href="#">Privacy</a>
                <a href="#">Terms of use</a>
                <a href="#">One Key<sup>TM</sup> terms and conditions</a>
                <a href="#">Accessibility</a>
                <a href="#">Your privacy choices</a>
            </div>
            <div class="footer__link--items">
                <p><strong>Help</strong></p>
                <a href="#">Support</a>
                <a href="#">Cancel your hotel</a>
                <a href="#">Refund timelines, policies & processes</a>
                <a href="#">Use a ItineraEase coupon</a>
            </div>
        </div>
    </div>
    <hr style="border: .1px solid lightgrey;">
    <div class="social__media">
        <div class="social__media--wrap">
            <p class="website__rights"> © 2024 ItineraEase, Inc., an ItineraEase 
              Group company. All rights reserved. ItineraEase and the ItineraEase 
              Logo are trademarks of ItineraEase, Inc.</p>
        </div>
    </div>
</footer>

<script>
    function myFunction() {
        document.getElementById("myDropdown").classList.toggle("show");
    }

// Close the dropdown menu if the user clicks outside of it
    window.onclick = function(event) {
        if (!event.target.matches('.dropbtn')) {
            var dropdowns = document.getElementsByClassName("dropdown-content");
            var i;
            for (i = 0; i < dropdowns.length; i++) {
                var openDropdown = dropdowns[i];
                if (openDropdown.classList.contains('show')) {
                    openDropdown.classList.remove('show');
                }   
            }
        }
    }
    const hamburgerMenu = document.querySelector(".hamburger_menu");
    const navMenu = document.querySelector(".nav_menu");
    hamburgerMenu.addEventListener("click", toggleMenu);

    function toggleMenu() {
        hamburgerMenu.classList.toggle("change");
        navMenu.classList.toggle("change");
    }
</script>