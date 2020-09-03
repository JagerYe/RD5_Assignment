<?php

require_once "{$_SERVER['DOCUMENT_ROOT']}/RD5_Assignment/models/transactionRecord/TransactionRecordDAO_PDO.php";
class TransactionRecordService
{
    public static function getDAO()
    {
        return new TransactionRecordDAO_PDO();
    }
}
