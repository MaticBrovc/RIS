<?php
require_once ("baza.php");

$filled = isset($_POST["username"]) && !empty($_POST["username"]) && isset($_POST["pass"]) && !empty($_POST["pass"]);
if ($filled) {
    try {
        $user = $_POST["username"];
        $pass = $_POST["pass"];
        Baza::confirmLogin($user, $pass);
    } catch (Exception $e) {
        $errorMessage = "Database error occured: $e";
    }
}
?>