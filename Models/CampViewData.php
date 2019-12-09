<?php
/**
 * Created by PhpStorm.
 * User: Abdi-rahman Musse
 * Date: 18/11/2018
 * Time: 15:56
 */
require_once('CampSuperData.php');
class CampViewData extends CampSuperData
{
    public function __construct($dbRow)
    {
        parent::__construct($dbRow);
    }
    //Everything is inside the superclass
}