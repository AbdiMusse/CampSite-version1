<?php
/**
 * Created by PhpStorm.
 * User: abdi21.aj
 * Date: 05/12/2018
 * Time: 20:19
 */
require_once('SuperDataSet.php');
require_once ('RequestData.php');

class RequestDataSet extends SuperDataSet
{
    protected $_dbHandle, $_dbInstance;

    public function __construct() {
        parent::__construct();
    }

    public function fetchAllRequest() {     //used in authorisation.php
        $sqlQuery = "select * from Request;";
        return parent::executeWithReturn($sqlQuery, 'RequestDataSet');
    }

    public function insertRequest($email) {     //used in index.php
        $sqlQuery = "insert into Request (user_email) values ('$email');";
        parent::execute($sqlQuery);
    }

    public function deleteRequest($email) {    //used in authorisation.php
        $sqlQuery = "delete from Request where user_email = '$email';";
        parent::execute($sqlQuery);
    }
}