<?php

require_once "{$_SERVER['DOCUMENT_ROOT']}/PID_Assignment/models/commodity/CommodityDAO_PDO.php";
class CommodityService
{
    private $_dao;
    function __construct()
    {
        $this->_dao = new CommodityDAO_PDO();
    }
    public function getDAO()
    {
        return $this->_dao;
    }
}
