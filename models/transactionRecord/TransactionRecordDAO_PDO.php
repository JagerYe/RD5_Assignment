<?php
require_once "{$_SERVER['DOCUMENT_ROOT']}/RD5_Assignment/models/transactionRecord/TransactionRecordDAO_Interface.php";
require_once "{$_SERVER['DOCUMENT_ROOT']}/RD5_Assignment/models/config.php";
class TransactionRecordDAO_PDO implements TransactionRecordDAO
{

    private $_strInsert = "INSERT INTO `TransactionRecord`
                            (`userID`, `transactionAmount`, `transactionDate`, `transactionChangeDate`, `status`) 
                            VALUES (:userID,
                                    :transactionAmount,
                                    CONVERT_TZ(NOW(),(SELECT @@time_zone),:userUTC),
                                    CONVERT_TZ(NOW(),(SELECT @@time_zone),:userUTC),
                                    :status);";
    private $_strUpdate = "UPDATE `TransactionRecord` 
                            SET `transactionAmount`=:transactionAmount,
                                `transactionChangeDate`=CONVERT_TZ(NOW(),(SELECT @@time_zone),:userUTC),
                                `status`=:status
                            WHERE `recordID`=:recordID;";
    private $_strDelete = "DELETE FROM `TransactionRecord` WHERE `recordID`=:recordID;";
    private $_strCheckRecordExist = "SELECT COUNT(*) FROM `TransactionRecord` WHERE `recordID`=:recordID;";
    private $_strGetAll = "SELECT 
                                `recordID`, 
                                `userID`, 
                                `transactionAmount`, 
                                `transactionDate`, 
                                `transactionChangeDate`,
                                `status`
                            FROM `TransactionRecord` 
                            ORDER BY `transactionChangeDate` DESC;";
    private $_strGetOne = "SELECT 
                                `recordID`, 
                                `userID`, 
                                `transactionAmount`, 
                                `transactionDate`, 
                                `transactionChangeDate`,
                                `status`
                            FROM `TransactionRecord` 
                            WHERE `recordID`=:recordID;";
    private $_strGetUserID = "SELECT 
                                    `recordID`, 
                                    `userID`, 
                                    `transactionAmount`, 
                                    `transactionDate`, 
                                    `transactionChangeDate`,
                                    `status`
                                FROM `TransactionRecord` 
                                WHERE `userID`=:userID 
                                ORDER BY `transactionChangeDate` DESC;";
    private $_strGetBalance = "SELECT SUM(`transactionAmount`) 
                                FROM `TransactionRecord` 
                                WHERE `userID`=:userID AND `status`='success';";
    private $_strGetHistoricalRecord = "SELECT 
                                        `recordID`, 
                                        `transactionDate`,
                                        `transactionAmount`,
                                        (SELECT SUM(`transactionAmount`) 
                                            FROM `TransactionRecord` AS t2 
                                            WHERE t2.`userID`=t1.`userID` 
                                                AND ((t2.`recordID`<t1.`recordID`) OR (t2.`recordID`=t1.`recordID`))) 
                                        AS `currentAmount` 
                                        FROM `TransactionRecord` AS t1 
                                        WHERE `userID`=:userID ORDER BY `transactionDate` DESC";

    //新增
    public function insertTransactionRecord($userID, $transactionAmount, $userUTC, $status)
    {
        try {
            $dbh = (new Config)->getDBConnect();
            $dbh->beginTransaction();
            $sth = $dbh->prepare($this->_strInsert);
            $sth->bindParam("userID", $userID);
            $sth->bindParam("transactionAmount", $transactionAmount);
            $sth->bindParam("userUTC", $userUTC);
            $sth->bindParam("status", $status);
            $sth->execute();
            $dbh->commit();
            $sth = null;
        } catch (Exception $err) {
            $dbh->rollBack();
            $dbh = null;
            return false;
        }
        $dbh = null;
        return true;
    }

    //新增 用物件
    public function insertTransactionRecordByObj($record)
    {
        return $this->insertTransactionRecord(
            $record->getUserID(),
            $record->getTransactionAmount(),
            $record->getUserUTC(),
            $record->getStatus()
        );
    }

    //更新
    public function updateTransactionRecord($record)
    {
        try {
            $dbh = (new Config)->getDBConnect();
            $dbh->beginTransaction();
            $sth = $dbh->prepare($this->_strUpdate);
            $sth->bindParam("transactionAmount", $record->getTransactionAmount());
            $sth->bindParam("userUTC", $record->getUserUTC());
            $sth->bindParam("status", $record->getStatus());
            $sth->bindParam("recordID", $record->getRecordID());
            $sth->execute();
            $dbh->commit();
            $sth = null;
        } catch (PDOException $err) {
            $dbh->rollBack();
            return false;
        }
        $dbh = null;
        return true;
    }

    public function deleteTransactionRecordByID($id)
    {
        try {
            $dbh = (new Config)->getDBConnect();
            $dbh->beginTransaction();
            $sth = $dbh->prepare($this->_strCheckRecordExist);
            $sth->bindParam("recordID", $id);
            $sth->execute();
            $request = $sth->fetch(PDO::FETCH_NUM);
            if ($request['0'] <= 0) {
                throw new Exception("找不到");
            }
            $sth = $dbh->prepare($this->_strDelete);
            $sth->bindParam("recordID", $id);
            $sth->execute();
            $dbh->commit();
            $sth = null;
        } catch (Exception $err) {
            $dbh->rollBack();
            return false;
        }
        $dbh = null;
        return true;
    }

    public function getAllTransactionRecords()
    {
        try {
            $dbh = (new Config)->getDBConnect();
            $sth = $dbh->prepare($this->_strGetAll);
            $sth->execute();
            $request = $sth->fetchAll(PDO::FETCH_ASSOC);
            $sth = null;
        } catch (PDOException $err) {
            $dbh->rollBack();
            return false;
        }
        $dbh = null;
        return TransactionRecord::dbDatasToModelsArray($request);
    }
    public function getOneTransactionRecordByID($id)
    {
        try {
            $dbh = (new Config)->getDBConnect();
            $sth = $dbh->prepare($this->_strGetOne);
            $sth->bindParam("recordID", $id);
            $sth->execute();
            $request = $sth->fetch(PDO::FETCH_ASSOC);
            $sth = null;
        } catch (PDOException $err) {
            return false;
        }
        $dbh = null;
        return TransactionRecord::dbDataToModel($request);
    }

    public function getTransactionRecordByUserID($id)
    {
        try {
            $dbh = (new Config)->getDBConnect();
            $sth = $dbh->prepare($this->_strGetUserID);
            $sth->bindParam("userID", $id);
            $sth->execute();
            $request = $sth->fetchAll(PDO::FETCH_ASSOC);
            $sth = null;
        } catch (PDOException $err) {
            $dbh->rollBack();
            return false;
        }
        $dbh = null;
        return TransactionRecord::dbDatasToModelsArray($request);
    }

    public function getUserBalance($id)
    {
        try {
            $dbh = (new Config)->getDBConnect();
            $sth = $dbh->prepare($this->_strGetBalance);
            $sth->bindParam("userID", $id);
            $sth->execute();
            $request = $sth->fetch(PDO::FETCH_NUM);
            $sth = null;
        } catch (Exception $err) {
            $dbh = null;
            return false;
        }
        $dbh = null;
        return $request['0'];
    }

    public function getUserHistoricalRecord($id)
    {
        try {
            $dbh = (new Config)->getDBConnect();
            $sth = $dbh->prepare($this->_strGetHistoricalRecord);
            $sth->bindParam("userID", $id);
            $sth->execute();
            $request = $sth->fetchAll(PDO::FETCH_ASSOC);
            $sth = null;
        } catch (Exception $err) {
            $dbh = null;
            return false;
        }
        $dbh = null;
        return TransactionRecord::dbDatasToModelsArray($request);
    }
}
