<?php
session_start();
$view = new stdClass();
$view->pageTitle = 'Camp Site';

require_once('Models/CampViewDataSet.php');
require_once ('Models/FavouriteDataSet.php');
require_once ('Models/RequestDataSet.php');
require_once ('pagination.php');        //Takes care of pagination in a different class

$campViewDataSet = new CampViewDataSet();
//Start of Search
$searchTerm = '';
if (isset($_POST['endSearch']) ) {
    unset($_SESSION['searchTerm']);         //unset the search session if the end search button is clicked
    header("location: index.php?pageNo=$view->pageNo");
}
if (isset($_POST['search'])) {
    if (! empty($_POST['searchText'])) {
        $_SESSION['searchTerm'] = $_POST['searchText'];     //set the session with what the user types
        $searchTerm = $_SESSION['searchTerm'];
        $view->campSites = $campViewDataSet->fetchSomeCampSite($searchTerm,$offset,$limit); //get the result with pagination working
    }
}
//End of search

//Start of filter
$toilet=$shower=$laundry=$water=$electricity=$internet=$forDisable=0;
$couple=$family=$sameSex=$under18=0;
$rating=10; $country='';

if (isset($_POST['endFilter']) ) {      //unset filter session if the end filter button is clicked
    unset($_SESSION['filter']);
    header("location: index.php?pageNo=$view->pageNo");
}
$view->filterCountry = $campViewDataSet->getMostFrequentCountry();        //used in the phtml page for looping top 5 countries
if (isset($_POST['filter'])) {

    //validation and storing the post into their variables
    if (!empty($_POST['facility'])) {
        foreach ($_POST['facility'] as $f) {
            if ($f == 'toilet') {$toilet = 1; }
            else if ($f == 'shower') {$shower = 1; }
            else if ($f == 'laundry') {$laundry = 1; }
            else if ($f == 'water') {$water = 1; }
            else if ($f == 'electricity') {$electricity = 1; }
            else if ($f == 'internet') {$internet = 1; }
            else if ($f == 'forDisable') {$forDisable = 1; }
        }
    }
    if(!empty($_POST['idealfor'])){
        foreach ($_POST['idealfor'] as $ppl) {
            if ($ppl == 'couple') {$couple = 1; }
            else if ($ppl == 'family') {$family = 1; }
            else if ($ppl == 'sameSex') {$sameSex = 1; }
            else if ($ppl == 'under18') {$under18 = 1; }
        }
    }
    if(!empty($_POST['stars'])){
        $rating = $_POST['stars'];
        $rating = $rating[0];
    }
    if(!empty($_POST['country'])){
        $country = $_POST['country'];
        $country = $country[0];
    }

    if (! empty($_POST['facility']) || ! empty($_POST['idealfor']) || !empty($_POST['stars']) || !empty($_POST['country'])) {
        //Do this part if at least one of the filters have been chosen

        $_SESSION['filter'] = array($rating, $country, $toilet, $shower, $laundry, $water,
            $electricity, $internet, $forDisable, $couple, $family, $sameSex, $under18);        //set the session and store all filter options in it

        $view->campSites = $campViewDataSet->fetchFilteredCampSite($searchTerm, $rating, $country, $toilet, $shower, $laundry, $water,
            $electricity, $internet, $forDisable, $couple, $family, $sameSex, $under18, $offset, $limit);   //return filter result with pagination
    }
}
//End of filter

//Sessions to maintain state through different pages of search and filter
if (isset($_SESSION['searchTerm'])) {
    $searchTerm = $_SESSION['searchTerm'];
    $view->campSites = $campViewDataSet->fetchSomeCampSite($searchTerm,$offset,$limit);
}
if ( isset($_SESSION['filter']))  {
    $filter = $_SESSION['filter'];
    $view->campSites = $campViewDataSet->fetchFilteredCampSite($searchTerm, $filter[0], $filter[1], $filter[2], $filter[3], $filter[4],
        $filter[5], $filter[6], $filter[7], $filter[8], $filter[9], $filter[10], $filter[11], $filter[12], $offset, $limit);
} else {
    $view->campSites = $campViewDataSet->fetchSomeCampSite($searchTerm,$offset,$limit);
}
//End of maintaining state for search and filter

//Favourites section
if (isset($_SESSION['email'])) {        //only do this part if the user is logged in
    $email = $_SESSION['email'];
    $favouriteDataSet = new FavouriteDataSet();
    $getAllFavourite = $favouriteDataSet->fetchUserAllFavourite($email);        //get all favourites of the current user
    if (count($getAllFavourite) > 0) {
        foreach ($getAllFavourite as $fav) {
            $allFavCampID[] = $fav->getCampID();        //store all camp id in the array
        }
        $_SESSION['favourites'] = $allFavCampID;        //set the session that holds all the campID of users' favourites
    }
}
if (isset($_POST['addToFavourite'])) {
    $campID = $_POST['favouriteID'];    //Get camp ID
    $getFavourite = $favouriteDataSet->checkFavouriteExists($campID, $email);       //checks if the user has favourited tis camp already by checking database
    if ( empty($getFavourite)) {
        $addToFavourite = $favouriteDataSet->insertFavourite($email, $campID);      //add the new favourite into the favourite table
    }
    header("location: index.php?pageNo=$view->pageNo");
}
//End of favourites

if (isset($_GET['authorisation'])) {        //only do this section if the user has a 'normal' status and clicks request authorisation
    $email = $_SESSION['email'];
    if (!isset($_SESSION['authorise'])) {
        $_SESSION['authorise'] = [];                    //used in the header to hide or show the request authorisation link
    }
    array_push($_SESSION['authorise'], $email);     //push all the users that clicked on the request button to the session
    $requestDataSet = new RequestDataSet();
    $addRequest =  $requestDataSet->insertRequest($email);      //adds the new request to the request table
}

if (isset($_GET['logout']))  {      //set all session that need unsetting and log out.
    unset($_SESSION['admin']);
    unset($_SESSION['authorised']);
    unset($_SESSION['normal']);
    unset($_SESSION['email']);
    unset($_SESSION['myRatings']);
    header('location: index.php');
}

require_once ('Views/index.phtml');