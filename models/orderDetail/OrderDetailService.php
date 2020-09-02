<?php

require_once "{$_SERVER['DOCUMENT_ROOT']}/PID_Assignment/models/orderDetail/OrderDetailDAO_PDO.php";
class OrderDetailService
{
    private $_dao;
    function __construct()
    {
        $this->_dao = new OrderDetailDAO_PDO();
    }
    public function getDAO()
    {
        return $this->_dao;
    }
}
