<?php

session_start();
require "Connect.php";
require "User.php";
require "Form.php";
require "Login.php";

$isemptyUsername = empty($_POST['updateUsername']);
$isemptyEmail = empty($_POST['updateMail']);
$isemptyPassword = empty($_POST['updatePassword']);
$issetVar = isset($_POST['updateUsername']) && isset($_POST['updateMail']) && isset($_POST['updatePassword']);
$filterUsername = isset($_POST['updateUsername']) ? filter_var($_POST['updateUsername'], FILTER_SANITIZE_STRING) : null;
$filterEmail = isset($_POST['email']) ? filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) : null;
$filterPassword = isset($_POST['updatePassword']) ? filter_var($_POST['updatePassword'], FILTER_SANITIZE_STRING) : null;


$connection = new Connect('127.0.0.1', 'becode', 'root', '');
$db = $connection->getPdo();
$user = new User($_SESSION['username'], $_SESSION['email'], $_SESSION['password']);

$form = new Form();
if (isset($_SESSION['idUser'])) {
    echo $form->button('se deconnecter', '/logout.php') . "Vous êtes connecté en tant que " . $_SESSION['username'] . '<br>';
}

$form->openForm('post', '#');
echo $form->textarea('updateUsername', "{$_SESSION['username']}");
if ($isemptyUsername) {
    echo "<p>cette valeur est obligatoire </p>";
}
echo $form->textarea('updateMail', "{$_SESSION['email']}");
if ($filterEmail) echo "<p>cest le bon format</p>";
else echo "<p>cest pas le bon format</p>";
if ($isemptyEmail) {
    echo "<p>cette valeur est obligatoire </p>";
}
echo $form->textarea('updatePassword', "");
if ($isemptyPassword) {
    echo "<p>cette valeur est obligatoire </p>";
}
echo $form->submit('modifier');
$form->closeForm();

if ($issetVar && !$isemptyUsername && $filterEmail && $filterPassword && $filterUsername) {
    if ($user->emailExist()) {
        echo 'ce mail existe<br>';
    }
    if ($user->UsernameExist()) {
        echo 'cette username existe<br>';

    }
    if (!$user->emailExist() && !$user->UsernameExist()) {

        $user->upDateUser($_POST['updateUsername'],$_POST['updateMail'],$_POST['updatePassword'],$_SESSION['id']);
        $_SESSION['username'] = $_POST['updateUsername'];
        $_SESSION['email'] = $_POST['updateMail'];
        echo 'vous avez modifié votre compte';
    }
}
