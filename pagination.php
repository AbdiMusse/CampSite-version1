<?php

require_once ('Models/Pagination.php');
require_once('Models/CampViewDataSet.php');
$pagination = new Pagination();

//Pagination
if (isset($_GET['pageNo'])) {
    $view->pageNo = $_GET['pageNo'];
} else {
    $view->pageNo  = 1;
}
$limit = $pagination->recordsPerPage(20);                          //How many record in each page
$offset = $pagination->calculateOffSet($view->pageNo);                            //How many campSites we have in total
$view->totalPages = $pagination->totalPages($pagination->totalNoOfCamps(),$limit); //How many pages we have in total
$view->starter = $pagination->getStarter($view->pageNo );
$view->holder = $pagination->getHolder($view->pageNo );
//End of pagination