<?php

require_once "{$_SERVER['DOCUMENT_ROOT']}/RD5_Assignment/models/transactionRecord/TransactionRecordDAO_PDO.php";
class TransactionRecordService
{
    private $_dao;
    function __construct()
    {
        $this->_dao = new TransactionRecordDAO_PDO();
    }
    public function getDAO()
    {
        return $this->_dao;
    }
}
