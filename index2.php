<?php
require_once('Models/CampViewDataSet.php');


$q = $_GET['q'];

$campViewDataSet = new CampViewDataSet();
$camp = $campViewDataSet->fetchCampSite($q);

var_dump($camp);
?>