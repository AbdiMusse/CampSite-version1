<?php
/**
 * Created by PhpStorm.
 * User: abdi21.aj
 * Date: 07/12/2018
 * Time: 11:29
 */

class Pagination
{
    protected $numberOfRecordPerPage, $totalNoOfPages, $noOfRows;

    public function recordsPerPage($numberOfRecords) {      //Calculates the limit
        $this->numberOfRecordPerPage = $numberOfRecords;
        return $numberOfRecords;
    }

    public function totalNoOfCamps() {
        $campViewDataSet = new CampViewDataSet();
        $noOfRows = $campViewDataSet->fetchNoOfCampSite();
        $noOfRows = $noOfRows[0];
        $this->noOfRows = $noOfRows;
        return $noOfRows;
    }

    public function totalPages($noOfRows, $noOfRecordPerPage) {     //Get total number of pages we need in the pagination
        $totalPages = ceil($noOfRows / $noOfRecordPerPage);
        $this->totalNoOfPages = $totalPages;
        return $totalPages;
    }

    public function calculateOffSet($pageNumber) {              //How many records to skip before we show record
        $offset = ($pageNumber-1) * $this->numberOfRecordPerPage;
        return $offset;
    }

    public function getStarter($pageNo) {
        $totalPages = $this->totalNoOfPages;
        $starter = 0;
        if ($pageNo >= 3 && $pageNo <= $totalPages-3) {
            $starter=$pageNo-1;
        } else if ($pageNo >= $totalPages-3) {
            $starter=$totalPages-3;
        } else if ($pageNo <= 3 && $totalPages > 4) {
            $starter = 2;
        }
        return $starter;
    }

    public function getHolder($pageNo) {
        $totalPages = $this->totalNoOfPages;
        $holder = 0;
        if ($pageNo >= 3 && $pageNo <= $totalPages-3) {
            $holder=$pageNo+2;
        } else if ($pageNo >= $totalPages-3) {
            $holder=$totalPages;
        } else if ($pageNo <= 3 && $totalPages > 4) {
            $holder=5;
        }
        return $holder;
    }
}