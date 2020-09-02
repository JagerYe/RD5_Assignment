<?php

require_once "{$_SERVER['DOCUMENT_ROOT']}/PID_Assignment/models/order/OrderDAO_PDO.php";
class OrderService
{
    private $_dao;
    function __construct()
    {
        $this->_dao = new OrderDAO_PDO();
    }
    public function getDAO()
    {
        return $this->_dao;
    }
}
