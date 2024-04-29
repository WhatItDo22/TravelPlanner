<?php include 'check.php'; ?>
<?php session_start() ?>
<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="faqstyles.css">
    <link rel="stylesheet" href="eventsstyles.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <title><?php echo $title; ?></title>
</head>

<body> 
<?php if ($loginst == 1) { ?>
    <div class="navbar">
        <a class="logo" href="default.php" id="home"><img src="images/logo.png" alt="Travel Logo"></a>
        <div class="nav_menu">
            <a href="search.php" id="search">Search</a>
            <a href="faq.php" id="faq">FAQ</a>
            <a href="contact.php" id="contact">Contact</a>
            <div class="dropdown">
                <a onclick="myFunction()" class="dropbtn">Account</a>
                <div id="myDropdown" class="dropdown-content">
                    <a href="savedtrips.php">Saved Trips</a>
                    <a href="logout.php">Log Out</a>
                </div>
            </div>
        </div>
        <div class="hamburger_menu">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
<?php } else { ?>
    <div class="navbar">
        <a class="logo" href="default.php" id="home"><img src="images/logo.png" alt="Travel Logo"></a>
        <div class="nav_menu">
            <a href="search.php" id="search">Search</a>
            <a href="faq.php" id="faq">FAQ</a>
            <a href="contact.php" id="contact">Contact</a>
            <a href="login.php" id="login">Log In</a>
        </div>
        <div class="hamburger_menu">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
<?php } ?>