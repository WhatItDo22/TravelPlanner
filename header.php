<?php
session_start();
$loginst = 0;
if (isset($_SESSION["user"])) {
    $loginst = 1;
}
?>

<?php if ($loginst == 0) { ?>
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
<?php } else { ?>
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
<?php } ?>