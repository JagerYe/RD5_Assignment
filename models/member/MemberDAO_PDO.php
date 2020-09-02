<?php
require_once "{$_SERVER['DOCUMENT_ROOT']}/RD5_Assignment/models/member/MemberDAO_Interface.php";
require_once "{$_SERVER['DOCUMENT_ROOT']}/RD5_Assignment/models/config.php";
class MemberDAO_PDO implements MemberDAO
{

    private $_strInsert = "INSERT INTO `Members`(`userID`, `userPassword`, `userName`, `userEmail`, `userPhone`, `userStatus`, `creationDate`, `changeDate`) VALUES (:userID,:userPassword,:userName,:userEmail,:userPhone,:userStatus,CONVERT_TZ(NOW(),(SELECT @@time_zone),:userUTC),CONVERT_TZ(NOW(),(SELECT @@time_zone),:userUTC));";
    private $_strUpdate = "UPDATE `Members` SET `userName`=:userName,`userEmail`=:userEmail,`userPhone`=:userPhone,`userStatus`=:userStatus,`changeDate`=CONVERT_TZ(NOW(),(SELECT @@time_zone),:userUTC) WHERE `userID`=:userID;";
    private $_strDelete = "DELETE FROM `Members` WHERE `userID` = :userID;";
    private $_strCheckMemberExist = "SELECT COUNT(*) FROM `Members` WHERE `userID` = :userID;";
    private $_strGetAll = "SELECT `userID`, `userPassword`, `userName`, `userEmail`, `userPhone`, `userStatus`, CONVERT_TZ(`creationDate`,(SELECT @@time_zone),:userUTC) AS 'creationDate',  CONVERT_TZ(`changeDate`,(SELECT @@time_zone),:userUTC) AS 'changeDate' FROM `Members`;";
    private $_strGetOne = "SELECT `userID`, `userPassword`, `userName`, `userEmail`, `userPhone`, `userStatus`, CONVERT_TZ(`creationDate`,(SELECT @@time_zone),:userUTC) AS 'creationDate',  CONVERT_TZ(`changeDate`,(SELECT @@time_zone),:userUTC) AS 'changeDate' FROM `Members` WHERE `userID` = :userID;";
    private $_strLoginID = "SELECT COUNT(`userID`) FROM `members` WHERE `userID`=:userID AND `userStatus` = true;";
    private $_strLoginPassword = "SELECT `userPassword` FROM `members` WHERE `userID`=:userID";

    //新增會員
    public function insertMember($id, $password, $name, $email, $phone, $status, $userUTC)
    {
        try {
            $dbh = (new Config)->getDBConnect();
            $dbh->beginTransaction();
            $sth = $dbh->prepare($this->_strInsert);
            $sth->bindParam("userID", $id);
            $password = password_hash($password, PASSWORD_DEFAULT);
            $sth->bindParam("userPassword", $password);
            $sth->bindParam("userName", $name);
            $sth->bindParam("userEmail", $email);
            $sth->bindParam("userPhone", $phone);
            $status = ($status) ? 1 : 0;
            $sth->bindParam("userStatus", $status);
            $sth->bindParam("userUTC", $userUTC);
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
    //新增會員 用物件
    public function insertMemberByObj($member)
    {
        return $this->insertMember(
            $member->getUserID(),
            $member->getUserPassword(),
            $member->getUserName(),
            $member->getUserEmail(),
            $member->getUserPhone(),
            $member->getUserStatus(),
            $member->getUserUTC()
        );
    }

    //更新會員
    public function updateMember($member)
    {
        try {
            $dbh = (new Config)->getDBConnect();
            $dbh->beginTransaction();
            $sth = $dbh->prepare($this->_strUpdate);
            $sth->bindParam("userID", $member->getUserID());
            $sth->bindParam("userName", $member->getUserName());
            $sth->bindParam("userEmail", $member->getUserEmail());
            $sth->bindParam("userPhone", $member->getUserPhone());
            $status = ($member->getUserStatus()) ? 1 : 0;
            $sth->bindParam("userStatus", $status);
            $sth->bindParam("userUTC", $member->getUserUTC());
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

    //之後需增加檢查是否有訂單
    public function deleteMemberByID($id)
    {
        try {
            $dbh = (new Config)->getDBConnect();
            $dbh->beginTransaction();
            $sth = $dbh->prepare($this->_strCheckMemberExist);
            $sth->bindParam("userID", $id);
            $sth->execute();
            $request = $sth->fetch(PDO::FETCH_NUM);
            if ($request['0'] != 1) {
                throw new Exception("找不到");
            }
            $sth = $dbh->prepare($this->_strDelete);
            $sth->bindParam("userID", $id);
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

    public function getAllMember()
    {
        try {
            $dbh = (new Config)->getDBConnect();
            $sth = $dbh->query($this->_strGetAll);
            $request = $sth->fetchAll(PDO::FETCH_ASSOC);
            $sth = null;
        } catch (PDOException $err) {
            $dbh->rollBack();
            echo ($err->__toString());
            return false;
        }
        $dbh = null;
        return Member::dbDatasToModelsArray($request);
    }
    public function getOneMemberByID($id)
    {
        try {
            $dbh = (new Config)->getDBConnect();
            $sth = $dbh->prepare($this->_strGetOne);
            $sth->bindParam("userID", $id);
            $sth->execute();
            $request = $sth->fetch(PDO::FETCH_ASSOC);
            $sth = null;
        } catch (PDOException $err) {
            echo ($err->__toString());
            return false;
        }
        $dbh = null;
        return Member::dbDataToModel($request);
    }

    public function doLogin($id, $password)
    {
        try {
            $dbh = (new Config)->getDBConnect();
            $sth = $dbh->prepare($this->_strLoginID);
            $sth->bindParam("userID", $id);
            $sth->execute();
            $request = $sth->fetch(PDO::FETCH_NUM);
            if ($request['0'] != 1) {
                throw new Exception("帳號密碼錯誤");
            }
            $sth = $dbh->prepare($this->_strLoginPassword);
            $sth->bindParam("userID", $id);
            $sth->execute();
            $request = $sth->fetch(PDO::FETCH_NUM);
            $sth = null;
        } catch (PDOException $err) {
            echo ($err->__toString());
            return false;
        }
        $dbh = null;
        return password_verify($password, $request['0']);
    }

    public function checkMemberExist($id)
    {
        try {
            $dbh = (new Config)->getDBConnect();
            $dbh->beginTransaction();
            $sth = $dbh->prepare($this->_strCheckMemberExist);
            $sth->bindParam("userID", $id);
            $sth->execute();
            $request = $sth->fetch(PDO::FETCH_NUM);
        } catch (Exception $err) {
            return false;
        }
        return $request['0'];
    }
}
