<?php
/**
 * Created by PhpStorm.
 * User: abdi21.aj
 * Date: 20/11/2018
 * Time: 22:04
 */
require_once('SuperDataSet.php');
require_once ('OwnerData.php');

class OwnerDataSet extends SuperDataSet
{
    protected $_dbHandle, $_dbInstance;

    public function __construct() {
        parent::__construct();      //calling the constructor of the super class
    }

    public function fetchOwner($email) {    //used in manageMyCamps.php
        $sqlQuery = "select * from Owner where user_email = '$email'";
        return parent::executeWithReturn($sqlQuery, 'OwnerDataSet');
    }

    public function fetchOwnerOfCamp($campID) {     //used in CampDetail.php
        $sqlQuery = "select * from Owner where camp_id = $campID;";
        return parent::executeWithReturn($sqlQuery, 'OwnerDataSet');
    }
}