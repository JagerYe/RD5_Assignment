<?php
class Member implements \JsonSerializable
{
    private $_userID;
    private $_userPassword;
    private $_userName;
    private $_userEmail;
    private $_userPhone;
    private $_userStatus;

    public function __construct($userID, $userName, $userEmail, $userPhone, $userStatus, $userPassword = 0)
    {
        $this->setUserID($userID);
        $this->setUserPassword($userPassword);
        $this->setUserName($userName);
        $this->setUserEmail($userEmail);
        $this->setUserPhone($userPhone);
        $this->setUserStatus($userStatus);
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
        $emailRule = "/^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z]+$/";
        if (!preg_match($emailRule, $userEmail)) {
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
