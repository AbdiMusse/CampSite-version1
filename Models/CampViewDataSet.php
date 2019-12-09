<?php
/**
 * Created by PhpStorm.
 * User: abdi21.aj
 * Date: 17/11/2018
 * Time: 11:50
 */
require_once('SuperDataSet.php');
require_once('CampViewData.php');

class CampViewDataSet extends SuperDataSet
{
    protected $_dbHandle, $_dbInstance;

    public function __construct() {
        parent::__construct();      //calling the constructor of the super class
    }

    public function fetchNoOfCampSite() {   //Used in manageMyCamp.php
        $sqlQuery =    "select count(*) from CampSite;";

        $statement = $this->_dbHandle->prepare($sqlQuery); // prepare a PDO statement
        $statement->execute(); // execute the PDO statement

        $campSite = $statement->fetch();
        return $campSite;
    }

    public function  getMostFrequentCountry() { //Used in index.php - for  getting top 5 country to choose for filter
        $sqlQuery = "select country, count(country) from CampSite
                     group by country order by count(country) desc limit 5;";

        $statement = $this->_dbHandle->prepare($sqlQuery); // prepare a PDO statement
        $statement->execute(); // execute the PDO statement

        $countries = [];
        while ($row = $statement->fetch()) {     //fetches the next row matching the query
            $countries[] = $row;
        }
        return $countries;
    }

    public function fetchSomeCampSite($text,$offset,$count) { //Used in index.php - for search & starting view
        $sqlQuery =    "select * from CampSite, Picture 
                        where Picture.camp_id = CampSite.camp_id
                        and (CampSite.camp_name LIKE ?) 
                        limit $offset,$count;";
        $text = "%$text%";
        return parent::executeWithParam1Return($sqlQuery,$text,'CampViewData');
    }

    public function fetchFilteredCampSite($campName, $rating, $country, $toilet, $shower, $laundry, $water, $electricity,
                                          $internet, $forDisable, $couple, $family, $sameSex, $under18, $offset, $count) {   //used in index.php

        $sqlQuery =    "select * from CampSite, Picture where Picture.camp_id = CampSite.camp_id and CampSite.camp_name = ? 
                        or Picture.camp_id = CampSite.camp_id and CampSite.rating = $rating 
                        or Picture.camp_id = CampSite.camp_id and CampSite.country = '$country'
                        or Picture.camp_id = CampSite.camp_id and CampSite.camp_id IN 
                        (select Facility.camp_id from Facility where Facility.toilet = $toilet
                        and Facility.shower = $shower and  Facility.laundry = $laundry
                        and  Facility.water = $water and  Facility.electricity = $electricity
                        and  Facility.internet = $internet and  Facility.disabled_facilities = $forDisable)
                        or Picture.camp_id = CampSite.camp_id and CampSite.camp_id IN
                        (select IdealFor.camp_id from IdealFor where IdealFor.couple = $couple
                        and IdealFor.family = $family and IdealFor.single_sex = $sameSex and IdealFor.under_18 = $under18)
                        limit $offset,$count;";
        return parent::executeWithParam1Return($sqlQuery, $campName,'CampViewData');
    }

    public function  fetchOneCampSite($id) { //used in fav.php
        $sqlQuery = "select * from CampSite, Picture where Picture.camp_id = CampSite.camp_id
                     and CampSite.camp_id = $id;";
        return parent::executeWithReturn($sqlQuery, 'CampViewData');
    }

    public function  fetchCampSite($searchTxt) { //used in fav.php
        $sqlQuery = "select * from CampSite, Picture where Picture.camp_id = CampSite.camp_id
                     and CampSite.camp_name  = '$searchTxt';";
        return parent::executeWithReturn($sqlQuery, 'CampViewData');
    }

    public function deleteRecord($_campID) {    //used in manageMyCamps.php

        $sqlQuery = "delete from Owner where camp_id = $_campID;
                     delete from Picture where camp_id = $_campID;
                     delete from Rating where camp_id = $_campID;
                     delete from IdealFor where camp_id = $_campID;
                     delete from Favourite where camp_id = $_campID;
                     delete from Facility where camp_id = $_campID;
                     delete from CampSite where camp_id = $_campID;";
        parent::execute($sqlQuery);
    }
}