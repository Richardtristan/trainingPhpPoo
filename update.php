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
$filterEmail = isset($_POST['updateMail']) ? filter_var($_POST['updateMail'], FILTER_VALIDATE_EMAIL) : null;
$filterPassword = isset($_POST['updatePassword']) ? filter_var($_POST['updatePassword'], FILTER_SANITIZE_STRING) : null;


$connection = new Connect('127.0.0.1', 'becode', 'root', '');
$db = $connection->getPdo();
$user = new User($_SESSION['username'], $_SESSION['email'], $_SESSION['password']);
$form = new Form();
if (isset($_SESSION['idUser'])) {
    echo $form->button('se deconnecter', '/logout.php') . "Vous êtes connecté en tant que " . $_SESSION['username'] . '<br>';
    echo $form->button('supprimé son compte', '/delete.php'). '<br>';
    echo $form->button("page d'acceuil", "/index.php");
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


if ($issetVar && !$isemptyUsername && $filterEmail && $filterPassword && $filterUsername && !$user->UpdateEmailExist($_POST['updateMail']) && !$user->UpdateUserExist($_POST['updateUsername'])) {

    $user->upDateUser($_POST['updateUsername'], $_POST['updateMail'], password_hash($_POST['updatePassword'],PASSWORD_BCRYPT), $_SESSION['idUser']);
    $_SESSION['username'] = $_POST['updateUsername'];
    $_SESSION['email'] = $_POST['updateMail'];
    echo 'vous avez modifié votre compte';
    header('location: update.php');

}else echo 'une des valeurs existes deja';

