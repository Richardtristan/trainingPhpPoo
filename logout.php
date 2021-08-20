<?php
session_start();
require "User.php";
if (!isset($_SESSION['idUser'])) {
    header('location: index.php');
}else{$user = new User($_SESSION['username'], $_SESSION['email'], $_SESSION['password']);

    $user->logout();}


