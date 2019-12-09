<?php
/**
 * Created by PhpStorm.
 * User: abdi21.aj
 * Date: 01/12/2018
 * Time: 11:33
 */

require_once('SuperDataSet.php');
require_once ('RatingData.php');

class RatingDataSet extends SuperDataSet
{
    protected $_dbHandle, $_dbInstance;

    public function __construct() {
        parent::__construct();
    }

    public function fetchOneCampRatings($campID) {       //used in campDetail.php
        $sqlQuery = "select * from Rating where camp_id = $campID;";
        return parent::executeWithReturn($sqlQuery, 'RatingDataSet');
    }

    public function fetchOneUserRatings($email) {       //used in campDetail.php - for the session
        $sqlQuery = "select * from Rating where email = '$email';";
        return parent::executeWithReturn($sqlQuery, 'RatingDataSet');
    }

    public function addRatingRecord($rating, $campID, $email) {   //used in campDetail.php
        $sqlQuery = "insert into Rating (rating,camp_id,email) values ($rating,$campID,'$email');";
        parent::execute($sqlQuery);
    }
}