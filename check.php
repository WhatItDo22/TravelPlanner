<?php
session_start();
$loginst = 0;
if ($_SESSION["user"]) {
    $loginst = 1;
}
?>