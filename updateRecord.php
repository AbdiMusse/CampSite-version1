<?php
session_start();
$view = new stdClass();
if (isset($_GET['edit'])) {
    $view->pageTitle = 'Edit CampSite';
} else if (isset($_GET['add'])) {
    $view->pageTitle = 'Add CampSite';
}

if (! isset($_SESSION['admin']) && ! isset($_SESSION['authorised']) ) {
    header("location: index.php");
}

require_once('Models/CampDetailedDataSet.php');
$campDetailedDataSet = new CampDetailedDataSet();

$view->errors = array();
$view->campName=$view->longitude=$view->latitude=$view->country=$view->address=$view->description=$picture=$openDays='';
$toilet=$shower=$laundry=$water=$electricity=$internet=$forDisable=0;
$couple=$family=$sameSex=$under18=0;

if (isset($_GET['campID'])) {                           //This is used for the editing part
    $campID = $_GET['campID'];
    $oneCamp = $campDetailedDataSet->fetchDetailedCampSite($campID);        //get the full details of a specific campsite
    $view->oneCamp = $oneCamp[0];

    $days = $view->oneCamp ->getOpenDays();
    $view->daysArray = explode(", ", $days);
    $view->facilities = $view->oneCamp ->checkFacilities();
    $view->idealFor = $view->oneCamp ->checkIdealFor();
}

if (isset($_POST['addRecord']) || isset($_POST['editRecord'])) {

    //Giving each input a variable and validation
    $view->campName = $_POST['campName'];
    $view->address = $_POST['address'];
    $view->country = $_POST['country'];
    $view->description = $_POST['description'];

    $view->longitude = $_POST['longitude'];
    if (! preg_match("/^(\+|-)?(?:180(?:(?:\.0{1,6})?)|(?:[0-9]|[1-9][0-9]|1[0-7][0-9])(?:(?:\.[0-9]{1,8})?))$/", $view->longitude)) {
        array_push($view->errors, 'Please enter a valid longitude.');
    }
    $view->latitude = $_POST['latitude'];
    if (! preg_match("/^(\+|-)?(?:90(?:(?:\.0{1,6})?)|(?:[0-9]|[1-8][0-9])(?:(?:\.[0-9]{1,8})?))$/", $view->latitude)) {
        array_push($view->errors, 'Please enter a valid latitude.');
    }

    if (!empty($_POST['days'])) {
        foreach ($_POST['days'] as $day) {
            $openDays = $openDays . $day . ', ';
        }
        $openDays = substr($openDays, 0, -2);
    } else {
        array_push($view->errors, 'Please select the days that your camp will be open');
    }

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
    } else {
        array_push($view->errors, 'Please select the facilities that your camp will have');
    }

    if(!empty($_POST['idealfor'])){
        foreach ($_POST['idealfor'] as $ppl) {
            if ($ppl == 'couple') {$couple = 1; }
            else if ($ppl == 'family') {$family = 1; }
            else if ($ppl == 'sameSex') {$sameSex = 1; }
            else if ($ppl == 'under18') {$under18 = 1; }
        }
    } else {
        array_push($view->errors, 'Please select the group of people your camp is best suited for');
    }

    $picture = $_POST['picture'];
    if (isset($_GET['edit'])) {
        if (empty($picture)) {
            $picture = $_POST['currentPic'];
        }
    }
    if (! empty($picture)) {
        $picArray = explode(".",$picture);
        $imageFileType = end($picArray);
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
            array_push($view->errors, 'Sorry, only JPG, JPEG, PNG & GIF files are allowed.');
        } else {
            if (file_exists("images/".$picture)) {
                array_push($view->errors, 'The image already exist, please change the image name and try again.');
            } else {
                copy($picture,"images/".$picture);
            }
        }
    }

    if (count($view->errors) == 0) {
        if (isset($_GET['edit'])) {
            $updateRecord = $campDetailedDataSet->updateOneCampSite($campID, $view->campName, $view->longitude, $view->latitude, $view->country, $view->address, $openDays,
                $view->description,$toilet, $shower, $laundry, $water, $electricity, $internet, $forDisable,
                $picture,$couple, $family, $sameSex, $under18);
            header('location: manageMyCamps.php');
        }
        if (isset($_GET['add'])) {
            $camps = $campDetailedDataSet->fetchDetailedCampSite('');
            $totalNoOfCamps = count($camps);
            $campID = $totalNoOfCamps + 1;      //create a new campID for the new camp
            $email = $_SESSION['email'];

            $newRecord = $campDetailedDataSet-> addCampSite($campID, $view->campName, $view->longitude, $view->latitude, $view->country, $view->address,
                $openDays, $view->description, $toilet, $shower, $laundry, $water, $electricity, $internet, $forDisable,
                $picture, $couple, $family, $sameSex, $under18, $email);
            header('location: index.php');
        }
    }
}

require_once('Views/updateRecord.phtml');