<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAQ</title>
    <link rel="stylesheet" href="styles.css">
    <style>
    </style>
</head>

<body> 
    <?php include 'header.php'; ?>
    <?php include 'footer.php'; ?>

    <script>
        var element = document.getElementById("contact");
        element.classList.add("active");

        const hamburgerMenu = document.querySelector(".hamburger_menu");
        const navMenu = document.querySelector(".nav_menu");
        hamburgerMenu.addEventListener("click", toggleMenu);

        function toggleMenu() {
            hamburgerMenu.classList.toggle("change");
            navMenu.classList.toggle("change");
        }
    </script>
</body>
</html>