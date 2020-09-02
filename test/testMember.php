<?php

use function PHPSTORM_META\type;

echo(gettype("01")."<br>");
echo(gettype(1)."<br>");
echo(is_string("01")."<br>");
echo(is_numeric(1)."<br>");
echo(is_numeric("1")."<br>");
// echo(__DIR__);
// var_dump($_SERVER);
// echo ($_SERVER["DOCUMENT_ROOT"]);
// echo("{$_SERVER['DOCUMENT_ROOT']}/PID_Assignment/models/Member.php");
require_once "{$_SERVER['DOCUMENT_ROOT']}/PID_Assignment/models/member/Member.php";
require_once "{$_SERVER['DOCUMENT_ROOT']}/PID_Assignment/models/member/MemberService.php";

// $member01 = new Member();
// var_dump($member01);
// $member02 = new Member("b01", "123456", "啾啾丸", "JoJoPlay@gmail.com", "0911213456");
// echo ($member02->getUserID() . "<br>");
// $memberDAO = (new MemberService())->getDAO();

//新增測試----------------------------------------
// $memberDAO->insertMember(
//     $member02->getUserID(),
//     $member02->getUserPassword(),
//     $member02->getUserName(),
//     $member02->getUserEmail(),
//     $member02->getUserPhone()
// );
// $memberDAO->insertMemberByObj($member02);
//新增測試----------------------------------------

//更新測試----------------------------------------
// if ($memberDAO->updateMember($member02)) {
//     echo ("OK");
// } else {
//     echo ("no");
// }
//更新測試----------------------------------------

//刪除測試----------------------------------------
// if ($memberDAO->deleteMemberByID($member02->getUserID())) {
//     echo ("OK");
// } else {
//     echo ("no");
// }
//刪除測試----------------------------------------

//取得所有測試----------------------------------------
// $members = $memberDAO->getAllMember();
// var_dump($members);

foreach ($members as $item) {
    var_dump($item);
    $item->showData();
}

for ($i = 0; $i < count($members); $i++) {
    $members[$i]->showData();
    var_dump($members[$i]);
}
//取得所有測試----------------------------------------

//取得指定會員測試----------------------------------------
// $member03 = $memberDAO->getOneMemberByID("a02");
// echo ($member03->showData());
//取得指定會員測試----------------------------------------

//登入----------------------------------------
// $request = $memberDAO->doLogin("a01", "123");
// echo ($request);
// if ($request == 1) {
//     echo ("ok");
// } else {
//     echo ("no");
// }
// echo("<hr>");
// $request = $memberDAO->doLogin("a01", "123456");
// echo ($request);
// if ($request == 1) {
//     echo ("ok");
// } else {
//     echo ("no");
// }
//登入----------------------------------------