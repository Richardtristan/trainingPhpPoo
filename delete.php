<?php
session_start();
require 'User.php';
require 'Connect.php';
require 'Form.php';

if (!isset($_SESSION['idUser'])){
    header('location: index.php');
}

$isemptyPassword = empty($_POST['passwordDelete']);
$varSet =  isset($_POST['passwordDelete']) && $_SESSION['idUser'] && $_SESSION['password'];




$connection = new Connect('127.0.0.1', 'becode', 'root', '');
$db = $connection->getPdo();
$user = new User($_SESSION['username'], $_SESSION['email'], $_SESSION['password']);
$form = new Form();
echo $form->button('se deconnecter', '/logout.php') . "Vous êtes connecté en tant que " . $_SESSION['username']. '<br>';
echo $form->button("mettre à jour son compte", "/update.php"). '<br>';
echo $form->button("page d'acceuil", "/index.php");
$form->openForm('post', '#');
echo $form->textarea('passwordDelete', 'mot de passe actuel');
echo $form->submit('delete');
$form->closeForm();
if ($isemptyPassword) {
    echo "<p>cette valeur est obligatoire </p>";
}

if (!$isemptyPassword && $varSet ) {
    $user->delete($_SESSION['idUser'],$_POST['passwordDelete'] ,$_SESSION['password']);
    echo 'compte supprimé';
    $user->logout();

}