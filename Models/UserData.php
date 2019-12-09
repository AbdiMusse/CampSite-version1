<?php
/**
 * Created by PhpStorm.
 * User: abdi21.aj
 * Date: 15/11/2018
 * Time: 19:03
 */

class UserData
{
    protected $_userName, $_password, $_firstName, $_lastName, $_gender, $_number, $_permission;

    public function __construct($dbRow) {
        $this->_userName = $dbRow['email'];
        $this->_password = $dbRow['password'];
        $this->_firstName = $dbRow['first_name'];
        $this->_lastName = $dbRow['last_name'];
        $this->_gender = $dbRow['gender'];
        $this->_number = $dbRow['number'];
        $this->_permission = $dbRow['permission'];
    }

    public function getUserName() {
        return $this->_userName;
    }
    public function getPassword() {
        return $this->_password;
    }
    public function getFirstName() {
        return $this->_firstName;
    }
    public function getLastName() {
        return $this->_lastName;
    }
    public function getGender() {
        return $this->_gender;
    }
    public function getUserNumber() {
        return $this->_number;
    }
    public function getPermission() {
        return $this->_permission;
    }
    public function isLoggedIn() {
        if (isset($_SESSION['email'])) {
            return true;
        }
    }
    public function checkUser() {
        if ($this->getPermission() == 'admin') {
            return 'admin';
        } else if ($this->getPermission() == 'authorised') {
            return 'authorised';
        } if ($this->getPermission() == 'normal') {
            return 'normal';
        }
    }
}