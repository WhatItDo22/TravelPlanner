<?php
    session_start();
    require_once("path/to/config.php");
    include(ROOT_PATH . "includes/header.php");
    $title = "ItineraEase | FAQ";
?>
    <?php include 'header.php'; ?>
    <div class="page-header">
        <h1 class="page-header-title">FAQ</h1>
        <p class="page-header-subtitle">Frequently Asked Questions</p>
    </div>
    <div class="faq-container">
        <div class="faq-image-box">
            <h1 class="faq-image-title">Have <br> questions?</h1>
            <img class="faq-image" src="images/faq-image.jpg">
        </div>
        <div class="faq-box">
            <div class="faq-wrapper">
                <input type="checkbox" class="faq-trigger" id="faq-trigger-1">
                <label for="faq-trigger-1" class="faq-title">How do I plan a road trip using the app?</label>
                <div class="faq-content">
                    <p>To plan a road trip using our app, simply navigate to the login section and create an account. Enter your starting point and destination, select any waypoints or stops you'd like to include, and customize your route preferences on the home page. Once you're satisfied with your trip plan, you can save it </p>
                </div>
            </div>
            <div class="faq-wrapper">
                <input type="checkbox" class="faq-trigger" id="faq-trigger-2">
                <label for="faq-trigger-2" class="faq-title">Does the app offer recommendations for attractions and restaurants along the way?</label>
                <div class="faq-content">
                    <p>Yes! Our app provides recommendations for attractions, restaurants, and other points of interest along your route. You can customize your preferences to filter recommendations based on your interests and preferences.</p>
                </div>
            </div>
            <div class="faq-wrapper">
                <input type="checkbox" class="faq-trigger" id="faq-trigger-3">
                <label for="faq-trigger-3" class="faq-title">Can I share my trip plan with friends and family?</label>
                <div class="faq-content">
                    <p>Yes! You can share your trip plan with friends and family by generating a shareable link or sending an invitation via email. Your friends and family can view your trip plan and collaborate on the itinerary.</p>
                </div>
            </div>
            <div class="faq-wrapper">
                <input type="checkbox" class="faq-trigger" id="faq-trigger-4">
                <label for="faq-trigger-4" class="faq-title">How do I access my saved trip plans?</label>
                <div class="faq-content">
                    <p>To access your saved trip plans, simply log in to your account and navigate to the "My Trips" section. Here, you'll find a list of all your saved trip plans, which you can view, edit, or delete as needed.</p>
                </div>
            </div>
            <div class="faq-wrapper">
                <input type="checkbox" class="faq-trigger" id="faq-trigger-5">
                <label for="faq-trigger-5" class="faq-title">Can I customize my route preferences, such as avoiding toll roads or highways?</label>
                <div class="faq-content">
                    <p>Yes! You can customize your route preferences to avoid toll roads, highways, or other specific road types. Simply adjust the settings on the home page to reflect your preferences, and the app will generate a route that meets your criteria.</p>
                </div>
            </div>
            <div class="faq-wrapper">
                <input type="checkbox" class="faq-trigger" id="faq-trigger-6">
                <label for="faq-trigger-6" class="faq-title">How do I provide feedback or report an issue with the app?</label>
                <div class="faq-content">
                    <p>To provide feedback or report an issue with the app, navigate to the "Contact Us" section and fill out the feedback form. You can also send an email to our support team at
                        <a href="mailto: support@itineraease.com"> support@itineraease.com</a></p>
                </div>
            </div>           
        </div>
    </div>  
    <?php include 'footer.php'; ?>
</body>
</html>