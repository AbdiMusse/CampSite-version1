<?php
session_start();
$view = new stdClass();
$view->pageTitle = 'Log in';

if (isset($_SESSION['email']) ) {
    header("location: index.php");
}

require_once ("Models/UsersDataSet.php");
require_once ('Models/CaptchaDataSet.php');

$view->errors = array();
$view->firstName=$view->lastName=$gender=$view->number=$view->email='';

//for captcha in phtml
$captchaDataSet = new CaptchaDataSet();
$view->captchaObjects = $captchaDataSet->fetchAllImages();      //get all captcha images
$view->num = rand(0,count($view->captchaObjects)-1);        //choose a random captcha to show user

if (isset($_POST["register"])) {
    //validation and setting posts to variables
    $view->firstName = $_POST['firstName'];
    $view->lastName = $_POST['lastName'];
    $view->email = $_POST['email'];
    $view->number = $_POST['number'];
    $password_1 = $_POST['password_1'];
    $password_2 = $_POST['password_2'];
    if (isset($_POST['gender'])) {
        $gender = $_POST['gender'];
    } else {
        array_push($view->errors, 'Please choose your gender.');
    }
    if (! preg_match("/([0-9\s\-]{7,})(?:\s*(?:#|x\.?|ext\.?|extension)\s*(\d+))?$/", $view->number)) {
        array_push($view->errors, 'Phone Number formatting is incorrect.');
    }
    if ($password_1 != $password_2) {
        array_push($view->errors, "The two passwords do not match.");
    }

    $userDataSet = new UsersDataSet();
    $user = $userDataSet->fetchOneUser($view->email);
    if (count($user) == 1) {                                //check if user exists
        array_push($view->errors, "email already exists");
    }

    //check is captcha word entered is correct
    $typedWord = $_POST['word'];
    $captcha = $captchaDataSet-> fetchOneImage($view->num+1);
    if (count($captcha) == 1) {
        if ($typedWord != $captcha[0]->getCaptchaWord()) {
            array_push($view->errors, "Incorrect word, please try again");
        }
    }

    if (count($view->errors) == 0) {
        $password = password_hash($password_1, PASSWORD_BCRYPT);        //encrypt the password
        $user = $userDataSet-> insetNewUser($view->email, $password, $view->firstName, $view->lastName, $gender, $view->number);

        //Set the needed sessions
        $_SESSION['normal'] = $view->email;
        $_SESSION['email'] = $view->email;
        header('location: index.php');
    }
}

require_once('Views/register.phtml');