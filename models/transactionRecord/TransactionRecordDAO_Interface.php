<?php
interface TransactionRecordDAO
{
    public function insertTransactionRecord($userID, $transactionAmount, $userUTC, $status);
    public function updateTransactionRecord($record);
    public function deleteTransactionRecordByID($id);
    public function getOneTransactionRecordByID($id);
    public function getAllTransactionRecords();
    public function getTransactionRecordByUserID($id);
    public function getUserBalance($id);
    public function getUserHistoricalRecord($id);
}
