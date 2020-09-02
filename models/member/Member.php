<?php
class Member implements \JsonSerializable
{
    private $_userID;
    private $_userPassword;
    private $_userName;
    private $_userEmail;
    private $_userPhone;
    private $_userStatus;
    private $_creationDate;
    private $_changeDate;
    private $_userUTC;
    private $_emailRule = "/^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z]+$/";
    private $_dateRule = "/\d{1,4}\/((1[0-2])|(0?[1-9]))\/((3[01])|([12]\d)|(0?[1-9])) ((2[0-4])|([01]?\d)){1}\:[0-5][0-9]\:[0-5][0-9]/";

    public function __construct(
        $userID,
        $userName,
        $userEmail,
        $userPhone,
        $userStatus,
        $creationDate,
        $changeDate,
        $userUTC,
        $userPassword = 0
    ) {
        $this->setUserID($userID);
        $this->setUserPassword($userPassword);
        $this->setUserName($userName);
        $this->setUserEmail($userEmail);
        $this->setUserPhone($userPhone);
        $this->setUserStatus($userStatus);
        $this->setCreationDate($creationDate);
        $this->setChangeDate($changeDate);
        $this->setUserUTC($userUTC);
    }

    public function getUserID()
    {
        return $this->_userID;
    }
    public function setUserID($userID)
    {
        if (!preg_match("/\w{6,30}/", $userID)) {
            throw new Exception("ID格式錯誤");
        }
        $this->_userID = $userID;
        return true;
    }

    public function getUserPassword()
    {
        return $this->_userPassword;
    }
    public function setUserPassword($userPassword)
    {
        $this->_userPassword = $userPassword;
        return true;
    }

    public function getUserName()
    {
        return $this->_userName;
    }
    public function setUserName($userName)
    {
        if ($userName === null || $userName == "") {
            throw new Exception("名字格式錯誤");
        }
        $this->_userName = $userName;
        return true;
    }

    public function getUserEmail()
    {
        return $this->_userEmail;
    }
    public function setUserEmail($userEmail)
    {

        if (!preg_match($this->_emailRule, $userEmail)) {
            throw new Exception("email格式錯誤");
        }
        $this->_userEmail = $userEmail;
        return true;
    }

    public function getUserPhone()
    {
        return $this->_userPhone;
    }
    public function setUserPhone($userPhone)
    {
        if (!preg_match("/\d{10}/", $userPhone)) {
            throw new Exception("電話錯誤");
        }
        $this->_userPhone = $userPhone;
        return true;
    }

    public function getUserStatus()
    {
        return $this->_userStatus;
    }
    public function setUserStatus($userStatus)
    {
        $this->_userStatus = $userStatus;
        return true;
    }

    public function getCreationDate()
    {
        return $this->_creationDate;
    }
    public function setCreationDate($creationDate)
    {
        if (!preg_match($this->_dateRule, $creationDate)) {
            throw new Exception("日期錯誤");
        }
        $this->_creationDate = $creationDate;
        return true;
    }

    public function getChangeDate()
    {
        return $this->_changeDate;
    }
    public function setChangeDate($changeDate)
    {
        if (!preg_match($this->_dateRule, $changeDate)) {
            throw new Exception("日期錯誤");
        }
        $this->_changeDate = $changeDate;
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

    public function jsonSerialize()
    {
        $vars = get_object_vars($this);
        return $vars;
    }

    public function showData()
    {
        echo ("<br>");
        echo ("ID:" . $this->getUserID());
        echo ("Password:" . $this->getUserPassword());
        echo ("Name:" . $this->getUserName());
        echo ("Email:" . $this->getUserEmail());
        echo ("Phone:" . $this->getUserPhone());
        echo ("Phone:" . $this->getUserPhone());
    }
}
