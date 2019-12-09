<?php
/**
 * Created by PhpStorm.
 * User: abdi21.aj
 * Date: 17/11/2018
 * Time: 11:14
 */

abstract class CampSuperData    //This is a superClass
{
    protected $_idCamp, $_campName, $_longitude, $_latitude, $_country, $_address, $_openDays, $_description, $_ratings;
    protected $_idPicture, $_picText, $_campid_p;

    public function __construct($dbRow) {
        $this->_idCamp = $dbRow['camp_id'];
        $this->_campName = $dbRow['camp_name'];
        $this->_longitude = $dbRow['longitude'];
        $this->_latitude = $dbRow['latitude'];
        $this->_country = $dbRow['country'];
        $this->_address = $dbRow['address'];
        $this->_openDays = $dbRow['open_days'];
        $this->_description = $dbRow['description'];
        $this->_ratings = $dbRow['rating'];

        $this->_idPicture = $dbRow['picture_id'];
        $this->_picText = $dbRow['picture_name'];
        $this->_campid_p = $dbRow['camp_id'];
    }
    //for CampSite table
    public function getCampID() {
        return $this->_idCamp;
    }
    public function getCampName() {
        return $this->_campName;
    }
    public function getLongitude() {
        return $this->_longitude;
    }
    public function getLatitude() {
        return $this->_latitude;
    }
    public function getCountry() {
        return $this->_country;
    }
    public function getAddress() {
        return $this->_address;
    }
    public function getOpenDays() {
        return $this->_openDays;
    }
    public function getDescription() {
        return $this->_description;
    }
    public function getRatings() {
        return $this->_ratings;
    }
    //for Picture table
    public function  getPicID() {
        return $this->_idPicture;
    }
    public function  getPicText() {
        return $this->_picText;
    }
    public function  getCampID_p() {
        return $this->_campid_p;
    }
}