<?php
/**
 * Created by PhpStorm.
 * User: abdi21.aj
 * Date: 29/11/2018
 * Time: 21:56
 */

class FavouriteData
{
    protected $_idFavourite, $_userEmail, $_campID;

    public function __construct($dbRow) {
        $this->_idFavourite = $dbRow['favourite_id'];
        $this->_userEmail = $dbRow['user_email'];
        $this->_campID = $dbRow['camp_id'];
    }

    public function getFavID() {
        return $this->_idFavourite;
    }
    public function getUserEmail() {
        return $this->_userEmail;
    }
    public  function getCampID() {
        return $this->_campID;
    }
}