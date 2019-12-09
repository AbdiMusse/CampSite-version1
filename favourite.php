<?php
session_start();
$view = new stdClass();
$view->pageTitle = 'My Favourites';

if (! isset($_SESSION['email']) ) {
    header("location: index.php");
}

require_once('Models/CampViewDataSet.php');
require_once ('Models/FavouriteDataSet.php');

$campViewDataSet = new CampViewDataSet();
$favouriteDataSet = new FavouriteDataSet();

$email = $_SESSION['email'];
$view->campSites = []; //So it works even if no campsite is chosen

$getFavourites = $favouriteDataSet->fetchUserAllFavourite($email);  //returns all favourite from 1 user
foreach ($getFavourites as $fav) {
    $idOfCamps[] = $fav->getCampID();       //Store all id that the user favourited
}

//Retrieve the tables and display them
$i=0;
for ($noOfFavourites = count($getFavourites); $noOfFavourites > 0; $noOfFavourites--) {
    $camp = $campViewDataSet->fetchOneCampSite($idOfCamps[$i]);
    $view->campSites[] = $camp[0]; $i++;
}
$view->numberOfCamps = count($view->campSites);     //Number of camps to display

if (isset($_POST['remove'])) {
    $campID = $_POST['remove-campID'];
    $campToRemove = $favouriteDataSet->removeFavourite($email, $campID);        //Remove the favourite from the database

    foreach ($_SESSION['favourites'] as $fav) {     //Dealing with the session of favourite
        if ($fav != $campID) {
            $allFavCampID[] = $fav;     //Put all favourites other than the one removed back into the session
        }
    }
    if (empty($allFavCampID)) {
        unset($_SESSION['favourites']);     //if no more favourite, then unset the session
    } else {
        $_SESSION['favourites'] = $allFavCampID;
    }
    header('location: favourite.php');
}

require_once ('Views/favourite.phtml');