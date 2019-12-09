<?php
/**
 * Created by PhpStorm.
 * User: abdi21.aj
 * Date: 29/11/2018
 * Time: 22:25
 */
require_once('SuperDataSet.php');
require_once ('FavouriteData.php');

class FavouriteDataSet extends SuperDataSet
{
    protected $_dbHandle, $_dbInstance;

    public function __construct() {
        parent::__construct();
    }

    public function checkFavouriteExists($campID, $email) {     //used in index.php
        $sqlQuery =    "select * from Favourite where camp_id = $campID and user_email = '$email';";
        return parent::executeWithReturn($sqlQuery, 'FavouriteDataSet');
    }

    public function fetchUserAllFavourite($email) {     //used in both index.php and fav.php
        $sqlQuery =    "select * from Favourite where user_email = '$email';";
        return parent::executeWithReturn($sqlQuery, 'FavouriteDataSet');
    }

    public function insertFavourite($email, $campID) {      //used in index.php
        $sqlQuery = "insert into Favourite (user_email, camp_id) values ('$email', $campID);";
        parent::execute($sqlQuery);
    }

    public function removeFavourite($email, $campID) {      //used in fav.php
        $sqlQuery = "delete from Favourite where user_email = '$email' and camp_id = $campID;";
        parent::execute($sqlQuery);
    }
}