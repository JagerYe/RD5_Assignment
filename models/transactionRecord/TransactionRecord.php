<?php
class TransactionRecord implements \JsonSerializable
{
    private $_recordID;
    private $_userID;
    private $_transactionAmount;
    private $_transactionDate;
    private $_transactionChangeDate;
    private $_userUTC;
    private $_status;
    private $_currentAmount;//當時餘額
    private $_dateRule = "/\d{1,4}\/((1[0-2])|(0?[1-9]))\/((3[01])|([12]\d)|(0?[1-9])) ((2[0-4])|([01]?\d)){1}\:[0-5][0-9]\:[0-5][0-9]/";

    public function __construct(
        $recordID,
        $userID,
        $transactionAmount,
        $transactionDate,
        $transactionChangeDate,
        $userUTC,
        $currentAmount = 0,
        $status = "success"
    ) {
        $this->setRecordID($recordID);
        $this->setUserID($userID);
        $this->setTransactionAmount($transactionAmount);
        $this->setTransactionDate($transactionDate);
        $this->setTransactionChangeDate($transactionChangeDate);
        $this->setUserUTC($userUTC);
        $this->setCurrentAmount($currentAmount);
        $this->setStatus($status);
    }

    public function getRecordID()
    {
        return $this->_recordID;
    }
    public function setRecordID($recordID)
    {
        if ($recordID == null || $recordID == "") {
            throw new Exception("ID格式錯誤");
        }
        $this->_recordID = $recordID;
        return true;
    }

    public function getUserID()
    {
        return $this->_userID;
    }
    public function setUserID($userID)
    {
        if ($userID == null || $userID == "") {
            throw new Exception("名稱格式錯誤");
        }
        $this->_userID = $userID;
        return true;
    }

    public function getTransactionAmount()
    {
        return $this->_transactionAmount;
    }
    public function setTransactionAmount($transactionAmount)
    {
        if ($transactionAmount == null || $transactionAmount == "") {
            throw new Exception("金額格式錯誤");
        }
        $this->_transactionAmount = $transactionAmount;
        return true;
    }

    public function getTransactionDate()
    {
        return $this->_transactionDate;
    }
    public function setTransactionDate($transactionDate)
    {
        if (!preg_match($this->_dateRule, $transactionDate)) {
            throw new Exception("日期錯誤");
        }
        $this->_transactionDate = $transactionDate;
        return true;
    }

    public function getTransactionChangeDate()
    {
        return $this->_transactionChangeDate;
    }
    public function setTransactionChangeDate($transactionChangeDate)
    {
        if (!preg_match($this->_dateRule, $transactionChangeDate)) {
            throw new Exception("日期錯誤");
        }
        $this->_transactionChangeDate = $transactionChangeDate;
        return true;
    }

    public function getCurrentAmount()
    {
        return $this->_currentAmount;
    }
    public function setCurrentAmount($currentAmount)
    {
        $this->_currentAmount = $currentAmount;
        return true;
    }

    public function getUserUTC()
    {
        return $this->_userUTC;
    }
    public function setUserUTC($userUTC)
    {
        if (!preg_match("/[+-]((1[0-2])|0?\d)\:[0-5]\d/", $userUTC)) {
            throw new Exception("時區格式錯誤");
        }
        $this->_userUTC = $userUTC;
        return true;
    }

    public function getStatus()
    {
        return $this->_status;
    }
    public function setStatus($status)
    {
        $this->_status = $status;
        return true;
    }

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}
