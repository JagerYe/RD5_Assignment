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
    private $_currentAmount; //當時餘額
    private $_dateRule = "/\d{1,4}-((1[0-2])|(0?[1-9]))-((3[01])|([12]\d)|(0?[1-9])) ((2[0-4])|([01]?\d)){1}\:[0-5][0-9]\:[0-5][0-9]/";

    public static function jsonStringToModel($jsonStr, $isInsert = false)
    {
        $jsonObj = json_decode($jsonStr);

        //如新增時_recordID就亂塞，最後由DB來生;userID抓Session
        if ($isInsert) {
            $jsonObj->_recordID = "???";
            $jsonObj->_userID = $_SESSION["userID"];
        }

        //這些參數由DB來生
        $jsonObj->_transactionDate = "2020-02-02 02:02:02";
        $jsonObj->_transactionChangeDate = "2020-02-02 02:02:02";

        return new TransactionRecord(
            $jsonObj->_recordID,
            $jsonObj->_userID,
            $jsonObj->_transactionAmount,
            $jsonObj->_transactionDate,
            $jsonObj->_transactionChangeDate,
            $jsonObj->_userUTC,
            $jsonObj->_currentAmount,
            $jsonObj->_status
        );
    }

    public static function jsonArrayStringToModelsArray($jsonStr, $isInsert = false)
    {
        $jsonArr = json_decode($jsonStr);
        foreach ($jsonArr as $jsonObj) {

            if ($isInsert) {
                $jsonObj->_recordID = "???";
            }

            $jsonObj->_transactionDate = "2020-02-02 02:02:02";
            $jsonObj->_transactionChangeDate = "2020-02-02 02:02:02";

            $records[] = new TransactionRecord(
                $jsonObj->_recordID,
                $jsonObj->_userID,
                $jsonObj->_transactionAmount,
                $jsonObj->_transactionDate,
                $jsonObj->_transactionChangeDate,
                $jsonObj->_userUTC,
                $jsonObj->_currentAmount,
                $jsonObj->_status
            );
        }
        return $records;
    }

    public static function dbDataToModel($request)
    {
        return new TransactionRecord(
            $request['recordID'],
            $request['userID'],
            $request['transactionAmount'],
            $request['transactionDate'],
            $request['transactionChangeDate'],
            "+00:00",
            $request['currentAmount'],
            $request['status']
        );
    }

    public static function dbDatasToModelsArray($requests)
    {
        foreach ($requests as $request) {
            $records[] = new TransactionRecord(
                $request['recordID'],
                $_SESSION['userID'],
                $request['transactionAmount'],
                $request['transactionDate'],
                $request['transactionChangeDate'],
                "+00:00",
                $request['currentAmount'],
                $request['status']
            );
        }
        return $records;
    }

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
