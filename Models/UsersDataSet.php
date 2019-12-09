<?php
/**
 * Created by PhpStorm.
 * User: abdi21.aj
 * Date: 15/11/2018
 * Time: 19:08
 */

require_once('SuperDataSet.php');
require_once ('UserData.php');

class UsersDataSet extends SuperDataSet
{
    protected $_dbHandle, $_dbInstance;

    public function __construct() {
        parent::__construct();
    }

    public function fetchOneUser($email) {      //Used in login.php & editProfile.php
        $sqlQuery = "SELECT * FROM User WHERE email=?;";
        return parent::executeWithParam1Return($sqlQuery, $email, 'UserDataSet');
    }

    public function updateUserPermission($email) {    //used in authorisation.php
        $sqlQuery = "update User set permission = 'authorised' where email = '$email';";
        parent::execute($sqlQuery);
    }

    public function insetNewUser($username, $password, $firstName, $lastName, $gender, $number) {   //used in register.php
        $sqlQuery = "INSERT INTO User (email, password, first_name, last_name, gender, number)  values (?,?,?,?,'$gender',?);";

        $statement = $this->_dbHandle->prepare($sqlQuery); // prepare a PDO statement
        $statement->bindParam(1,$username);
        $statement->bindParam(2,$password);
        $statement->bindParam(3,$firstName);
        $statement->bindParam(4,$lastName);
        $statement->bindParam(5,$number);
        $statement->execute(); // execute the PDO statement
    }

    public function updateUser($password, $firstName, $lastName, $gender, $number, $username, $email) { //used in editProfile.php
        $sqlQuery = "update User set password = ? where email = '$email';
                     update User set first_name = ? where email = '$email';
                     update User set last_name = ? where email = '$email';
                     update User set gender = '$gender' where email = '$email';
                     update User set number = ? where email = '$email';
                     update User set email = ? where email = '$email';";

        $statement = $this->_dbHandle->prepare($sqlQuery); // prepare a PDO statement
        $statement->bindParam(1,$password);
        $statement->bindParam(2,$firstName);
        $statement->bindParam(3,$lastName);
        $statement->bindParam(4,$number);
        $statement->bindParam(5,$username);
        $statement->execute(); // execute the PDO statement
    }
}