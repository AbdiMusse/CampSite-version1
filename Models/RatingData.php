<?php
/**
 * Created by PhpStorm.
 * User: abdi21.aj
 * Date: 01/12/2018
 * Time: 11:32
 */

class RatingData
{
    protected  $_idRating, $_ratingNo, $_campid, $_userEmail;

    public function __construct($dbRow) {
        $this->_idRating = $dbRow['rating_id'];
        $this->_ratingNo = $dbRow['rating'];
        $this->_campid = $dbRow['camp_id'];
        $this->_userEmail = $dbRow['email'];
    }

    public function getRatingID() {
        return $this->_idRating;
    }
    public  function getRating() {
        return $this->_ratingNo;
    }
    public function getCampID_r() {
        return $this->_campid;
    }
    public function getUserEmail() {
        return $this->_userEmail;
    }
}