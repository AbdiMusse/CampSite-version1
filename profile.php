<?php
session_start();
$view = new stdClass();
$view->pageTitle = 'Profile';


if (! isset($_SESSION['email']) ) {
    header("location: index.php");
}

require_once ('Models/UsersDataSet.php');
$userDataSet = new UsersDataSet();

$email = $_SESSION['email'];
$user = $userDataSet->fetchOneUser($email);     //get the user details to edit
$view->user = $user[0];

require_once ('Views/profile.phtml');