<?php
session_start();
$loginst = 1;
if (isset($_SESSION["user"])) {
    $loginst = 0;
}
?>