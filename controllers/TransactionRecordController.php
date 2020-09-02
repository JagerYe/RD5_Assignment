<?php
class TransactionRecordController extends Controller
{
    private $_dao;
    public function __construct()
    {
        require_once "{$_SERVER['DOCUMENT_ROOT']}/RD5_Assignment/models/transactionRecord/TransactionRecordService.php";
        require_once "{$_SERVER['DOCUMENT_ROOT']}/RD5_Assignment/models/member/MemberService.php";
        $this->_dao = (new TransactionRecordService())->getDAO();
        $this->model("transactionRecord");
    }

    private function jsonToModel($str, $isInsert = false)
    {
        $obj = json_decode($str);

        //如新增時id就亂塞，最後由DB來生
        if ($isInsert) {
            $obj->_recordID = "???";
        }

        //這些參數由DB來生
        $obj->_transactionDate = "2020/02/02 02:02:02";
        $obj->_transactionChangeDate = "2020/02/02 02:02:02";

        //交易狀態暫時不做
        try {
            $order = new TransactionRecord(
                $obj->_recordID,
                $obj->_userID,
                $obj->_transactionAmount,
                $obj->_transactionDate,
                $obj->_transactionChangeDate,
                $obj->_userUTC
            );
        } catch (Exception $err) {
            return false;
        }

        return $order;
    }

    public function insertByObj($str)
    {
        if (!($record = $this->jsonToModel($str, true))) {
            return false;
        }

        if ($id = $this->_dao->insertTransactionRecordByObj($record)) {
            return true;
        }

        return false;
    }

    public function update($str)
    {
        if (!($record = $this->jsonToModel($str))) {
            return false;
        }

        if ($id = $this->_dao->updateTransactionRecord($record)) {
            return true;
        }
        return false;
    }

    public function delete($id)
    {
        if ($this->_dao->deleteTransactionRecordByID($id)) {
            return true;
        }
        return false;
    }

    public function getAll($userUTC)
    {

        if ($records = $this->_dao->getAllTransactionRecords()) {
            return json_encode($records);
        }
        return false;
    }

    public function getOne($userUTC, $id)
    {
        if ($record = $this->_dao->getOneTransactionRecordByID($id)) {
            return json_encode($record);
        }
        return false;
    }

    public function getUserTransactionRecords($id)
    {
        if (!isset($_SESSION['userID'])) {
            return false;
        }
        if ($records = $this->_dao->getTransactionRecordByUserID($id)) {
            return json_encode($records);
        }
        return false;
    }

    public function getUserBalance($id)
    {
        if ($balance = $this->_dao->getUserBalance($id)) {
            return json_encode($balance);
        }
        return false;
    }

    public function getUserHistoricalRecord($id)
    {
        if ($records = $this->_dao->getUserHistoricalRecord($id)) {
            return json_encode($records);
        }
        return false;
    }
}
