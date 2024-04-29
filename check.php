<?php
session_start();
$loginst = 0;
var_dump($_SESSION["user"]);
if (isset($_SESSION["user"])) {
    $loginst = 1;
}
if (isset($_SESSION["test"])) {
    $loginst = 3;
}
?>