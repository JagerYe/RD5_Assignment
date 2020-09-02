<?php
class Employee implements \JsonSerializable
{
    private $_empID;
    private $_empPassword;

    public function __construct($empID, $empPassword = 0)
    {
        $this->setEmpID($empID);
        $this->setEmpPassword($empPassword);
    }

    public function getEmpID()
    {
        return $this->_empID;
    }
    public function setEmpID($empID)
    {
        if ($empID == null || $empID == "") {
            throw new Exception("ID格式錯誤");
        }
        $this->_empID = $empID;
        return true;
    }

    public function getEmpPassword()
    {
        return $this->_empPassword;
    }
    public function setEmpPassword($empPassword)
    {
        $this->_empPassword = $empPassword;
        return true;
    }

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }

    public function showData()
    {
        echo ("<br>");
        echo ("ID:" . $this->getEmpID());
        echo ("Password:" . $this->getEmpPassword());
    }
}
