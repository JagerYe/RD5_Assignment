<?php
$rule = "/\d{1,4}\/((1[0-2])|(0?[1-9]))\/((3[01])|([12]\d)|(0?[1-9])) ((2[0-4])|([01]?\d)){1}\:[0-5][0-9]\:[0-5][0-9]/";
//        年      /         月              /         日                       空白     時               :    分       :   秒
// echo ($i = preg_match($rule, "2020/08/07 01:51:30") . "<hr>");
// echo ($i = preg_match($rule, "2020/13/07 01:51:30") . "<hr>");
// echo ($i = preg_match($rule, "2020/08/32 01:51:30") . "<hr>");
// echo ($i = preg_match($rule, "2020/08/07 25:51:30") . "<hr>");
// echo ($i = preg_match($rule, "2020/08/07 01:60:30") . "<hr>");
// echo ($i = preg_match($rule, "2020/08/07 01:51:611") . "<hr>");
// echo ($i = preg_match($rule, "2020/08/07 01:51:1") . "<hr>");

$rrr="/[+-]((1[0-2])|0?\d)\:[0-5]\d/";
echo ($i = preg_match($rrr, "+08:00") . "<hr>");
echo ($i = preg_match($rrr, "-08:00") . "<hr>");
echo ($i = preg_match($rrr, "+13:00") . "<hr>");
echo ($i = preg_match($rrr, "08:00") . "<hr>");
echo ($i = preg_match($rrr, "+08:99") . "<hr>");
echo ($i = preg_match($rrr, "+08:") . "<hr>");
