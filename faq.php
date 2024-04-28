<!DOCTYPE html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="styles.css">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
        <title>FAQ</title>
        <style>
            :root {
                --primary-color: #f5b104;
                --whiteColor: #fff;
                --darkColor: #333;
            }

            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
                font-family: 'Poppins', sans-serif;
                outline: none;
            }

            body {
                width: 100%;
                height: auto;
                padding: 3%;
                background-color: var(--whiteColor);
            }
            .page-header {
                background-image: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('images/sky.jpg');
                background-position: top center;
                background-repeat: no-repeat;
                background-size: cover;
                display: flex;
                flex-direction: column;
                align-items: center;
                padding: 5% 3%;
                border-radius: 30px;
                max-height: 300px;
                color: var(--whiteColor);
            }

            .page-header-title {
                font-size: 40px;
                letter-spacing: 1.5;
            }

            .page-header-subtitle {
                font-size: 14px;
                letter-spacing: 1;
                text-align: center;
            }

            .search-container {
                display: flex;
                justify-content: space-between;
                padding: 5px;
                margin-top: 5%;
                width: 60%;
                height: 50px;
                background-color: var(--whiteColor);
                border-radius: 30px;
            }

            .search-container input {
                width: 80%;
                height: 100%;
                padding: 1% 3%;
                background: transparent;
                border: none;
            }
            .search-container button {
                width: 20%;
                min-width: 100px;
                height: 100%;
                background-color: var(--primary-color);
                color: var(--whiteColor);
                border: none;
                border-radius: 30px;
                cursor: pointer;
            }

            .search-container button:hover {
                background-color: var(--darkColor);
            }

            .faq-container {
                width: 100%;
                display: flex;
                flex-wrap: wrap;
                align-items: flex-start;
                padding: 3%;
            }
            .faq-image-box {
                flex: 0.5;
                padding: 2% 2% 0 0;
            }

            .faq-image-title {
                padding: 5% 0 0 0;
                font-size: 40px;
                letter-spacing: 2;
            }

            .faq-image {
                width: 100%;
                max-width: 400px;
            }
            .faq-box {
                flex: 1;
                min-width: 320px;
                padding: 2% 0 4% 4%;
                border-left: 2px solid var(--darkColor);
            }
            .faq-wrapper {
                width: 100%;
                padding: 1.5rem;
                border-bottom: 1px solid var(--darkColor);

            }
            .faq-title {
                display: block;
                position: relative;
                width: 100%;
                letter-spacing: 1.2;
                font-size: 24px;
                font-weight: 600;
                color: var(--darkColor);

            }
            .faq-title::after {
                width: 10px;
                height: 10px;
                content: '';
                float: right;
                border-style: solid;
                border-width: 2px 2px 0 0;
                transform: rotate(135deg);
                transition: 0.4s ease-in-out;
            }
            .faq-content {
                line-height: 1.5;
                max-height: 0;
                overflow: hidden;
                transition: max-height 0.3s ease-in-out;
                font-size: 14px;
            }
            .faq-trigger {
                display: none;
            }

            .faq-trigger:checked + .faq-title + .faq-content {
                max-height: 300px;
            }

            .faq-trigger:checked + .faq-title::after {
                transform: rotate(-45deg);
                transition: 0.4s ease-in-out;
            }

            @media screen and (max-width: 680px) {
                .page-header {
                    padding: 10% 3%;
                }
                .search-container {
                    width: 100%;
                }
                .faq-container {
                    flex-direction: column;
                }
                .faq-image-box {
                    padding: 0;
                }
                .faq-box {
                    padding: 0;
                    border-left: none;
                }
            }
        </style>
    </head>
    <body>
        <?php include 'header.php'; ?>
        <div class="page-header">
            <h1 class="page-header-title">FAQ</h1>
            <p class="page-header-subtitle">Frequently Asked Questions</p>

            <div class="search-container">
                <input type="text" placeholder="Search...">
                <button>Search</button>
            </div>
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