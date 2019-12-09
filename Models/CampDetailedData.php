<?php
/**
 * Created by PhpStorm.
 * User: Abdi-rahman Musse
 * Date: 17/11/2018
 * Time: 11:14
 */
require_once('CampSuperData.php');
class CampDetailedData extends CampSuperData
{
    protected $_facilities, $_idFacility, $_toilet, $_shower, $_laundry, $_water, $_electricity, $_internet, $_forDisabled, $_campid_f;
    protected $_idealFor, $_idIdealFor, $_couple, $_family, $_singleSexGroup, $_under18, $_campid_i;
    protected  $_idRating, $_ratingNo, $_campid_r, $email_r;

    public function __construct($dbRow) {
        parent::__construct($dbRow);        //calling the constructor of the super class

        $this->_idFacility = $dbRow['facility_id'];
        $this->_toilet = $dbRow['toilet'];
        $this->_shower = $dbRow['shower'];
        $this->_laundry = $dbRow['laundry'];
        $this->_water = $dbRow['water'];
        $this->_electricity = $dbRow['electricity'];
        $this->_internet = $dbRow['internet'];
        $this->_forDisabled = $dbRow['disabled_facilities'];
        $this->_campid_f = $dbRow['camp_id'];
        $this->_facilities = array('toilet'=>$this->_toilet,'shower'=>$this->_shower,'laundry'=>$this->_laundry,
                            'water'=>$this->_water,'electricity'=>$this->_electricity,'internet'=>$this->_internet,
                            'disabled facilities'=>$this->_forDisabled);

        $this->_idIdealFor = $dbRow['idealFor_id'];
        $this->_couple = $dbRow['couple'];
        $this->_family = $dbRow['family'];
        $this->_singleSexGroup = $dbRow['single_sex'];
        $this->_under18 = $dbRow['under_18'];
        $this->_campid_i = $dbRow['camp_id'];
        $this->_idealFor = array('couples'=>$this->_couple, 'family'=>$this->_family,
                            'single_sex_group'=>$this->_singleSexGroup, 'under_18'=>$this->_under18);
    }
    //for Facility table
    public function checkFacilities() {
        $actualList = [];
        foreach ($this->_facilities as $fac=>$fac_value) {
            if ($fac_value == 1) {
                array_push($actualList, $fac);
            }
        }
        return $actualList;
    }
    //for IdealFor table
    public function checkIdealFor() {
        $actualList = [];
        foreach ($this->_idealFor as $idealFor=>$idealFor_value) {
            if ($idealFor_value == 1) {
                array_push($actualList, $idealFor);
            }
        }
        return $actualList;
    }
}