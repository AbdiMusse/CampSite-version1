<?php
session_start();
$view = new stdClass();

require_once('Models/CampDetailedDataSet.php');
require_once('Models/UsersDataSet.php');
require_once('Models/OwnerDataSet.php');
require_once ('Models/RatingDataSet.php');

//Show the camp chosen
$campDetailedDataSet = new CampDetailedDataSet();
$campSites = $campDetailedDataSet->fetchDetailedCampSite('');   //No parameter since we don't need an id
if (isset($_GET['id'])) {
    $campID = $_GET['id'];
    $value = $campID - 1;
    $view->camp = $campSites[$value];           //display the actual camp object
}
//Get the user information if the user is logged in and is authorised
if (isset($_SESSION['admin']) || (isset($_SESSION['authorised'])) ) {
    $ownerDataSet = new OwnerDataSet();
    $owner = $ownerDataSet->fetchOwnerOfCamp($campID);
    $ownerEmail = $owner[0]->getOwnerEmail();
    $userDataSet = new UsersDataSet();
    $user = $userDataSet->fetchOneUser($ownerEmail);    //To get the details of the owner and not logged in user
    $view->user = $user[0];
}
//Rating starts here
$ratingDataSet = new RatingDataSet();
if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
    $userRatings = $ratingDataSet->fetchOneUserRatings($email);
    if (count($userRatings) > 0) {
        foreach ($userRatings as $r) {
            $allUserRatings[] = $r->getCampID_r();
        }
        $_SESSION['myRatings'] = $allUserRatings;        //Session holds all the campID of users' favourites
    }
}
if (isset($_POST['giveRating'])) {
    if (! empty($_POST['star'])) {
        $rate = $_POST['star'];
        $rate = $rate[0];                   //Convert the array to string - the rating the user chose
        $campID = $_POST['rateCampID'];     //Get camp id for rating
        //Add to the rating table
        $addToRating = $ratingDataSet->addRatingRecord($rate, $campID, $email);
        //Get the total rating from one camp site
        $getAllRatings = $ratingDataSet->fetchOneCampRatings($campID);  //Get all ratings from one campsite
        $i = 0; $campRating=0;
        foreach ($getAllRatings as $rateRow) {
            $campRating += $rateRow->getRating();
            //$campRating += $ratings[$i]; $i++;  //you can delete this if the above works and get rid of $i
        }
        //do the calculation to get rating of camp
        $noOfRatings = count($getAllRatings);   //number of ratings made
        $realRating = $campRating/$noOfRatings;
        //Update the rating in the camp site table campsite table
        $updateRating = $campDetailedDataSet->updateCampRating($campID, $realRating);
        header("location: campDetail.php?id=$campID");
    }
    //Rating ends here
}

require_once ('Views/campDetail.phtml');