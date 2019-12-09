<?php
/**
 * Created by PhpStorm.
 * User: abdi21.aj
 * Date: 16/11/2018
 * Time: 21:52
 */

class CaptchaData
{
    protected $_idCaptcha, $_pictureText, $_word;

    public function __construct($dbRow) {
        $this->_idCaptcha = $dbRow['captcha_id'];
        $this->_pictureText = $dbRow['picture_text'];
        $this->_word = $dbRow['captcha_word'];
    }

    public function getCaptchaID() {
        return $this->_idCaptcha;
    }
    public function getPictureText() {
        return $this->_pictureText;
    }
    public function getCaptchaWord() {
        return $this->_word;
    }
}