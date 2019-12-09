<?php
session_start();
$view = new stdClass();
$view->pageTitle = 'Authorisation';

if (! isset($_SESSION['admin']) ) {
    header("location: index.php");
}

require_once ('Models/RequestDataSet.php');
require_once ('Models/UsersDataSet.php');

$requestDataSet = new RequestDataSet();
$view->requests = $requestDataSet->fetchAllRequest();
$view->numberOfRequest = count($view->requests);        //Get the number of request to show in phtml

if (isset($_GET['add']) || isset($_GET['remove'])) {
    if (isset($_GET['add'])) {
        $userEmail = $_GET['add'];              //Get email of user to authorise
        $userDataSet = new UsersDataSet();
        $updatePermission = $userDataSet->updateUserPermission($userEmail);     //Make the user an authorised user
        $deleteRequest = $requestDataSet->deleteRequest($userEmail);            //Delete that request from the Request table
    }
    if (isset($_GET['remove'])) {
        $userEmail = $_GET['remove'];
        $deleteRequest = $requestDataSet->deleteRequest($userEmail);    //Delete that request from the Request table without authorisation
    }
    //Dealing with the session - get rid of that users name in the session
    if (in_array($userEmail,$_SESSION['authorise'])) {
        foreach ($_SESSION['authorise'] as $a) {
            if ($a != $userEmail) {             //if it's not the current user we're dealing with, put it back into the array
                $stillToAuthorise[] = $a;
            }
        }
        if (empty($stillToAuthorise)) {
            unset($_SESSION['authorise']);          //unset the session if there are no more users to authorise
        } else {
            $_SESSION['authorise'] = $stillToAuthorise;
        }
    }
    header('location: authorisation.php');
}
require_once('Views/authorisation.phtml');