<?php

require_once "{$_SERVER['DOCUMENT_ROOT']}/PID_Assignment/models/member/MemberDAO_PDO.php";
class MemberService
{
    private $_dao;
    function __construct()
    {
        $this->_dao = new MemberDAO_PDO();
    }
    public function getDAO()
    {
        return $this->_dao;
    }
}
