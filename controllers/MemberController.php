<?php
class MemberController extends Controller
{
    private $_dao;
    public function __construct()
    {
        require_once "{$_SERVER['DOCUMENT_ROOT']}/RD5_Assignment/models/member/MemberService.php";
        $this->_dao = (new MemberService())->getDAO();
        $this->model("member");
    }

    private function jsonToModel($str, $isInsert = false)
    {
        $obj = json_decode($str);
        if ($isInsert) {
            $obj->_userStatus = true;
            $obj->_creationDate = "?????";
            $obj->_changeDate = "????";
        }
        try {
            $member = new Member(
                $obj->_userID,
                $obj->_userName,
                $obj->_userEmail,
                $obj->_userPhone,
                $obj->_userStatus,
                $obj->_creationDate,
                $obj->_changeDate,
                $obj->_userUTC,
                $obj->_userPassword
            );
        } catch (Exception $err) {
            return false;
        }

        return $member;
    }

    public function insertByObj($str)
    {

        if (!($member = $this->jsonToModel($str, true))) {
            return false;
        }
        $password = $member->getUserPassword();
        if (!preg_match("/\w{6,30}/", $password)) {
            return false;
        }

        if ($this->_dao->insertMemberByObj($member)) {
            return true;
        }

        return false;
    }

    public function update($str)
    {
        if (!($member = $this->jsonToModel($str))) {
            return false;
        }

        $password = $member->getUserPassword();
        if (!preg_match("/\w{6,30}/", $password)) {
            return false;
        }

        if ($this->_dao->updateMember($member)) {
            return true;
        }
        return false;
    }

    public function delete($id)
    {
        if ($this->_dao->deleteMemberByID($id)) {
            return true;
        }
        return false;
    }

    public function getAll()
    {
        if ($members = $this->_dao->getAllMember()) {
            return json_encode($members);
        }
        return false;
    }

    public function getOne($id)
    {
        if ($member = $this->_dao->getOneMemberByID($id)) {
            $a = json_encode($member);
            return $a;
        }
        return false;
    }

    public function login($id, $password)
    {
        if ($this->_dao->doLogin($id, $password) == 1) {
            $member = $this->_dao->getOneMemberByID($id);

            $_SESSION["userID"] = $member->getUserID();
            $_SESSION["userName"] = $member->getUserName();

            return true;
        }
        return false;
    }

    public function getSessionUserName()
    {
        if (isset($_SESSION['userName'])) {
            return $_SESSION['userName'];
        }
        return false;
    }

    public function logout()
    {
        unset($_SESSION['userID']);
        unset($_SESSION['userName']);
    }

    public function checkMemberExist($id)
    {
        return ($this->_dao->checkMemberExist($id)) > 0;
    }
}
