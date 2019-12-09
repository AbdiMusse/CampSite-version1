<?php
/**
 * Created by PhpStorm.
 * User: abdi21.aj
 * Date: 13/12/2018
 * Time: 13:35
 */
require_once ('Database.php');

abstract class SuperDataSet     //This is super class
{
    protected $_dbHandle, $_dbInstance;

    public function __construct() {
        $this->_dbInstance = Database::getInstance();
        $this->_dbHandle = $this->_dbInstance->getdbConnection();
    }

    protected function execute($sqlQuery) {
        $statement = $this->_dbHandle->prepare($sqlQuery); // prepare a PDO statement
        $statement->execute(); // execute the PDO statement
    }

    protected function executeWithReturn($sqlQuery, $className) {
        $statement = $this->_dbHandle->prepare($sqlQuery); // prepare a PDO statement
        $statement->execute(); // execute the PDO statement

        $object = [];
        while ($row = $statement->fetch()) {     //fetches the next row matching the query
            if ($className == 'CampDetailedDataSet') {
                $object[]  = new CampDetailedData($row);
            } else if ($className == 'CampViewData') {
                $object[] = new CampViewData($row);
            } else if ($className == 'CaptchaDataSet') {
                $object[] = new CaptchaData($row);
            } else if ($className == 'FavouriteDataSet') {
                $object[] = new FavouriteData($row);
            } else if ($className == 'OwnerDataSet') {
                $object[] = new OwnerData($row);
            } else if ($className == 'RatingDataSet') {
                $object[] = new RatingData($row);
            } else if ($className == 'RequestDataSet') {
                $object[] = new RequestData($row);
            }
        }
        return $object;
    }

    protected function executeWithParam1Return($sqlQuery, $item, $className) {
        $statement = $this->_dbHandle->prepare($sqlQuery); // prepare a PDO statement
        $statement->bindParam(1,$item);
        $statement->execute(); // execute the PDO statement

        $object = [];
        while ($row = $statement->fetch()) {     //fetches the next row matching the query
            if ($className == 'CampViewData') {
                $object[] = new CampViewData($row);
            } else if ($className == 'UserDataSet') {
                $object[] = new UserData($row);
            }
        }
        return $object;
    }
}