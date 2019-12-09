<?php
session_start();
$view = new stdClass();
$view->pageTitle = 'Manage Camps';

if (! isset($_SESSION['admin']) && ! isset($_SESSION['authorised']) ) {
    header("location: index.php");
}

require_once('Models/CampViewDataSet.php');
require_once ('Models/OwnerDataSet.php');
require_once ('pagination.php');        //Takes care of pagination in a different class

$campViewDataSet = new CampViewDataSet();

if (isset($_SESSION['authorised']) )  {

    $email = $_SESSION['email'];
    $ownerDataSet = new OwnerDataSet();
    $owner = $ownerDataSet->fetchOwner($email);     //Gets 1 owner with all it's camps

    if (count($owner) > 0) {
        //Get camp ids from Owner table
        foreach ($owner as $ownerRow) {
            $campIDs[] = $ownerRow->getCampID();
        }
        //Retrieve all camps that are owned by the current user logged in
        foreach ($campIDs as $campID) {
            $camps = $campViewDataSet->fetchOneCampSite($campID);
            $view->campSites[] = $camps[0];
        }
        $view->numberOfCamps = count($view->campSites);             //get the number of camps to show
    } else {
        $view->numberOfCamps = 0;
    }
}
if (isset($_SESSION['admin'])) {
    $total = $campViewDataSet->fetchNoOfCampSite();
    $view->campSites = $campViewDataSet->fetchSomeCampSite('',$offset,$limit);    //gets all camps in the database with pagination
    $view->numberOfCamps = count($view->campSites);
}

if (isset($_POST['delete'])) {
    $deleteCampID = $_POST['use-campID'];
    $campToDelete = $campViewDataSet->deleteRecord($deleteCampID);          //delete camp from the database
    header('location: manageMyCamps.php');
}
if (isset($_POST['edit'])) {
    $editCampID = $_POST['use-campID'];
    header("location: updateRecord.php?campID=$editCampID&edit=1");
}

require_once ('Views/manageMyCamps.phtml');