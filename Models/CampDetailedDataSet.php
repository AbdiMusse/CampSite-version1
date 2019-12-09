<?php
/**
 * Created by PhpStorm.
 * User: Abdi-rahman Musse
 * Date: 17/11/2018
 * Time: 11:50
 */
require_once('SuperDataSet.php');
require_once('CampDetailedData.php');

class CampDetailedDataSet extends SuperDataSet
{
    protected $_dbHandle, $_dbInstance;

    public function __construct() {
        parent::__construct();      //calling the constructor of the super class
    }

    public function updateCampRating($campID,$rating) {     //Used in campDetail.php
        $sqlQuery = "update CampSite set rating = $rating where camp_id = $campID;";
        parent::execute($sqlQuery);
    }

    public function fetchDetailedCampSite($id) { //Used in campDetail.php & updateRecord.php
        $sqlQuery =    "select * from CampSite, Facility, Picture, IdealFor, Owner
						where CampSite.camp_id like '%$id'
                        and (Facility.camp_id = CampSite.camp_id)
                        and (Picture.camp_id = CampSite.camp_id)
                        and (IdealFor.camp_id = CampSite.camp_id)
                        and (Owner.camp_id = CampSite.camp_id);";
        return parent::executeWithReturn($sqlQuery, 'CampDetailedDataSet');
    }

    public function updateOneCampSite($campID, $campName, $longitude, $latitude, $country, $address, $openDays, $description,
                                      $toilet, $shower, $laundry, $water, $electricity, $internet, $forDisabled, $picText,
                                      $couple, $family, $singleSexGroup, $under18) { //Used in updateRecord.php

        $sqlQuery =    "update CampSite set camp_name = ? where CampSite.camp_id = $campID;
                        update CampSite set longitude = ? where CampSite.camp_id = $campID;
                        update CampSite set latitude = ? where CampSite.camp_id = $campID;
                        update CampSite set country = ? where CampSite.camp_id = $campID;
                        update CampSite set address = ? where CampSite.camp_id = $campID;
                        update CampSite set open_days = '$openDays' where CampSite.camp_id = $campID;
                        update CampSite set description = ? where CampSite.camp_id = $campID;
                        update Facility set toilet = $toilet where Facility.camp_id = $campID;
                        update Facility set shower = $shower where Facility.camp_id = $campID;
                        update Facility set laundry = $laundry where Facility.camp_id = $campID;
                        update Facility set water = $water where Facility.camp_id = $campID;
                        update Facility set electricity = $electricity where Facility.camp_id = $campID;
                        update Facility set internet = $internet where Facility.camp_id = $campID;
                        update Facility set disabled_facilities = $forDisabled where Facility.camp_id = $campID;
                        update IdealFor set couple = $couple where IdealFor.camp_id = $campID;
                        update IdealFor set family = $family where IdealFor.camp_id = $campID;
                        update IdealFor set single_sex = $singleSexGroup where IdealFor.camp_id = $campID;
                        update IdealFor set under_18 = $under18 where IdealFor.camp_id = $campID;
                        update Picture set picture_name = '$picText' where Picture.camp_id = $campID;";
        $this->prepareAndExecute($sqlQuery, $campName, $longitude, $latitude, $country, $address, $description);
    }

   public function addCampSite($campID, $campName, $longitude, $latitude, $country, $address, $openDays, $description,
                             $toilet, $shower, $laundry, $water, $electricity, $internet, $forDisabled, $picText,
                             $couple, $family, $singleSexGroup, $under18, $email) {        //Used in updateRecord.php
       $sqlQuery = "insert into CampSite (camp_id, camp_name, longitude, latitude, country, address, open_days, description)
                    values ($campID,?,?,?,?,?,'$openDays',?);
                    insert into Facility (toilet, shower, laundry, water, electricity, internet, disabled_facilities, camp_id)
                    values ($toilet,$shower,$laundry,$water,$electricity,$internet,$forDisabled,$campID);
                    insert into Picture (picture_name,camp_id)
                    values ('$picText',$campID);
                    insert into IdealFor (couple, family, single_sex, under_18, camp_id)
                    values ($couple,$family,$singleSexGroup,$under18,$campID);
                    insert into Owner (user_email, camp_id)
                    values ('$email',$campID);";
       $this->prepareAndExecute($sqlQuery, $campName, $longitude, $latitude, $country, $address, $description);
   }

    private function prepareAndExecute($sqlQuery, $campName, $longitude, $latitude, $country, $address, $description) {
        //Used in addCampSite() & updateOneCampSite()
        $statement = $this->_dbHandle->prepare($sqlQuery); // prepare a PDO statement
        $statement->bindParam(1,$campName);
        $statement->bindParam(2,$longitude);
        $statement->bindParam(3,$latitude);
        $statement->bindParam(4,$country);
        $statement->bindParam(5,$address);
        $statement->bindParam(6,$description);
        $statement->execute(); // execute the PDO statement
    }
}