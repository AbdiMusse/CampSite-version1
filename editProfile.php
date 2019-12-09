<?php
session_start();
$view = new stdClass();
$view->pageTitle = 'Edit Profile';

$view->errors = array();
$firstName=$lastName=$gender=$number=$userName=$password1=$password2='';    //store post variables here

if (! isset($_SESSION['email']) ) {
    header("location: index.php");
}
require_once ('Models/UsersDataSet.php');
$userDataSet = new UsersDataSet();

$email = $_SESSION['email'];
$user = $userDataSet->fetchOneUser($email);     //get the current user logged in
$view->user = $user[0];

if (isset($_POST['editProfile'])) {
    //Some validations and storing the post in the variables
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    if (isset($_POST['gender'])) {
        $gender = $_POST['gender'];
    } else {
        array_push($view->errors, 'Please select a gender.');
    }
    $number = $_POST['number'];
    if (! preg_match("/([0-9\s\-]{7,})(?:\s*(?:#|x\.?|ext\.?|extension)\s*(\d+))?$/", $number)) {   //a regular expression for phone number
        array_push($view->errors, 'Phone Number formatting is incorrect.');
    }
    $userName = $_POST['userName'];
    $password1 = $_POST['password1'];
    $password2 = $_POST['password2'];
    if ($password1 != $password2) {
        array_push($view->errors, "The two passwords do not match.");
    }

    $testUser = $userDataSet->fetchOneUser($userName);
    if (count($testUser) == 1 && $userName != $email) { //check if user exists
        array_push($view->errors, "email already exists");
    }

    if (count($view->errors) == 0) {
        $password = password_hash($password1, PASSWORD_BCRYPT);     //Encrypt the password before changing and storing in the database
        $newUser = $userDataSet->updateUser($password, $firstName, $lastName, $gender, $number, $userName, $email);
        $_SESSION['email'] = $userName;
        header("location: profile.php");
    }
}
require_once ('Views/editProfile.phtml');