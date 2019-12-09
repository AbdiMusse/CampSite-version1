<?php
/**
 * Created by PhpStorm.
 * User: abdi21.aj
 * Date: 05/12/2018
 * Time: 20:18
 */

class RequestData
{
    protected $_idRequest, $_userEmail;

    public function __construct($dbRow) {
        $this->_idRequest = $dbRow['request_id'];
        $this->_userEmail = $dbRow['user_email'];
    }

    public function getRequestID() {
        return $this->_idRequest;
    }
    public function getUserEmail() {
        return $this->_userEmail;
    }
}