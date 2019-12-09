<?php
/**
 * Created by PhpStorm.
 * User: abdi21.aj
 * Date: 15/11/2018
 * Time: 19:08
 */
require_once('SuperDataSet.php');
require_once ('CaptchaData.php');

class CaptchaDataSet extends SuperDataSet
{
    protected $_dbHandle, $_dbInstance;

    public function __construct() {
        parent::__construct();
    }

    public function fetchOneImage($id) {    //Used in register.php
        $sqlQuery = "SELECT * FROM Captcha WHERE captcha_id=$id;";
        return parent::executeWithReturn($sqlQuery, 'CaptchaDataSet');
    }

    public function fetchAllImages() {      //Used in register.php
        $sqlQuery = "SELECT * FROM Captcha";
        return parent::executeWithReturn($sqlQuery, 'CaptchaDataSet');
    }
}