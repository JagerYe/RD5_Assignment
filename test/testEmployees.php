<?php

require_once "{$_SERVER['DOCUMENT_ROOT']}/PID_Assignment/models/employee/Employee.php";
require_once "{$_SERVER['DOCUMENT_ROOT']}/PID_Assignment/models/employee/EmployeeService.php";

$employees01 = new Employee("b01", "123456");
$employees02 = new Employee("b02", "123456");
echo ($employees02->getEmpID() . "<br>");
$employeesDAO = (new EmployeeService())->getDAO();

//新增測試----------------------------------------
$employeesDAO->insertEmployee(
    $employees01->getEmpID(),
    $employees01->getEmpPassword()
);
$employeesDAO->insertEmployeeByObj($employees02);
echo ("<hr>");
//新增測試----------------------------------------

//更新測試----------------------------------------
$employees02->setEmpPassword("111222");
if ($employeesDAO->updateEmployee($employees02)) {
    echo ("OK");
} else {
    echo ("no");
}
echo ("<hr>");
//更新測試----------------------------------------

//刪除測試----------------------------------------
if ($employeesDAO->deleteEmployeeByID($employees02->getEmpID())) {
    echo ("OK");
} else {
    echo ("no");
}
echo ("<hr>");
//刪除測試----------------------------------------

//取得所有測試----------------------------------------
$employeess = $employeesDAO->getAllEmployees();
var_dump($employeess);

//此方法會讓$item得不到member的class
// foreach ($members as $item) {
//     var_dump($item);
//     $item->showDate();
// }

for ($i = 0; $i < count($employeess); $i++) {
    $employeess[$i]->showData();
}
echo ("<hr>");
//取得所有測試----------------------------------------

//取得指定會員測試----------------------------------------
$employees03 = $employeesDAO->getOneEmployeeByID("emp1");
echo ($employees03->showData());
echo ("<hr>");
//取得指定會員測試----------------------------------------

//登入----------------------------------------
echo ("失敗測試<br>");
$request = $employeesDAO->doLogin("a01", "123");
echo ($request);
if ($request == 1) {
    echo ("ok");
} else {
    echo ("no");
}
echo ("<hr>");
echo ("成功測試<br>");
$request = $employeesDAO->doLogin($employees01->getEmpID(), $employees01->getEmpPassword());
echo ($request);
if ($request == 1) {
    echo ("ok");
} else {
    echo ("no");
}
echo ("<hr>");
//登入----------------------------------------