<?php
class EmployeeController extends Controller
{
    private $_dao;
    public function __construct()
    {
        require_once "{$_SERVER['DOCUMENT_ROOT']}/PID_Assignment/models/employee/EmployeeService.php";
        $this->_dao = (new EmployeeService())->getDAO();
        $this->model("employee");
    }

    private function jsonToModel($str)
    {
        $obj = json_decode($str);
        $employee = new Employee(
            $obj->_empID,
            $obj->_empPassword
        );
        $password = $employee->getEmpPassword();
        if ($password == null || strlen($password) <= 0) {
            return false;
        }
        return $employee;
    }

    public function insert($id, $password)
    {
        if ($password == null || strlen($password) <= 0) {
            return false;
        }

        if ($this->_dao->insertEmployee($id, $password)) {
            return true;
        }
        return false;
    }

    public function insertByObj($str)
    {

        if (!($employee = $this->jsonToModel($str))) {
            return false;
        }

        if ($this->_dao->insertEmployeeByObj($employee)) {
            return true;
        }

        return false;
    }

    public function update($str)
    {
        if (!($employee = $this->jsonToModel($str))) {
            return false;
        }

        if ($this->_dao->updateEmployee($employee)) {
            return true;
        }
        return false;
    }

    public function delete($id)
    {
        if ($this->_dao->deleteEmployeeByID($id)) {
            return true;
        }
        return false;
    }

    public function getAll()
    {
        if ($employees = $this->_dao->getAllEmployees()) {
            return json_encode($employees);
        }
        return false;
    }

    public function getOne($id)
    {
        if ($employee = $this->_dao->getOneEmployeeByID($id)) {
            return json_encode($employee);
        }
        return false;
    }

    public function login($id, $password)
    {
        if ($this->_dao->doLogin($id, $password) == 1) {
            $employee = $this->_dao->getOneEmployeeByID($id);

            $_SESSION["empID"] = $employee->getEmpID();

            return true;
        }
        return false;
    }

    public function getSessionEmpID()
    {
        if (isset($_SESSION['empID'])) {
            return $_SESSION['empID'];
        }
        return false;
    }

    public function logout()
    {
        unset($_SESSION['empID']);
    }
}
