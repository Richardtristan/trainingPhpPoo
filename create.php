<?php
session_start();
require "Connect.php";
require "User.php";
require "Form.php";
require "Login.php";

$isemptyUsername = empty($_POST['username']);
$isemptyEmail = empty($_POST['email']);
$isemptyPassword = empty($_POST['password']);
$issetVar = isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password']);
$filterUsername = isset($_POST['username']) ? filter_var($_POST['username'], FILTER_SANITIZE_STRING) : null;
$filterEmail = isset($_POST['email']) ? filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) : null;
$filterPassword = isset($_POST['password']) ? filter_var($_POST['password'], FILTER_SANITIZE_STRING) : null;


$connection = new Connect('127.0.0.1', 'becode', 'root', '');
$db = $connection->getPdo();

$form = new Form();

if (isset($_SESSION['idUser'])){
    header('location: index.php');
}else     echo $form->button('se connecter','/index.php');

$form->openForm('post', '#');
echo $form->textarea('username', '');
if ($isemptyUsername) {
    echo "<p>cette valeur est obligatoire </p>";
}
echo $form->textarea('email', '');
if ($filterEmail) echo "<p>cest le bon format</p>";
else echo "<p>cest pas le bon format</p>";
if ($isemptyEmail) {
    echo "<p>cette valeur est obligatoire </p>";
}
echo $form->textarea('password', '');
if ($isemptyPassword) {
    echo "<p>cette valeur est obligatoire </p>";
}
echo $form->submit('envoyer');
$form->closeForm();

if ($issetVar && !$isemptyUsername && $filterEmail && $filterPassword && $filterUsername) {
    $user = new User(trim($_POST['username']), trim($_POST['email']), password_hash(trim($_POST['password']),PASSWORD_BCRYPT));
    if ($user->emailExist()) {
        echo 'ce mail existe<br>';
    }
    if ($user->UsernameExist()){
        echo 'cette username existe<br>';

    }if (!$user->emailExist() && !$user->UsernameExist()){
        $user->createUser();
        echo 'vous êtes inscrit';
    }
}
?>