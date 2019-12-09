<?php
/**
 * Created by PhpStorm.
 * User: abdi21.aj
 * Date: 20/11/2018
 * Time: 21:57
 */

class OwnerData
{
    protected $_idOwner, $_ownerEmail, $_campID;

    public function __construct($dbRow) {
        $this->_idOwner = $dbRow['owner_id'];
        $this->_ownerEmail = $dbRow['user_email'];
        $this->_campID = $dbRow['camp_id'];
    }

    public function getOwnerID() {
        return $this->_idOwner;
    }
    public function getOwnerEmail() {
        return $this->_ownerEmail;
    }
    public function getCampID() {
        return $this->_campID;
    }
}