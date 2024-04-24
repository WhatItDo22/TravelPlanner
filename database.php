<?php
$servername = "localhost";
$username = "upjomg4jsiwwg";
$password = "g94wspgywq8e";
$db = "dbxr6uvbrsv2dg";

$conn = mysqli_connect($servername, $username, $password, $db);
if (!$conn) {
    die("Something went wrong. Please try again later.");
}