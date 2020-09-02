<?php
$hash = password_hash("123456", PASSWORD_DEFAULT);
echo ("$hash<hr>");
$hash1 = password_hash("123456", PASSWORD_DEFAULT);
echo ("$hash1<hr>");
$hash2 = password_hash("123456", PASSWORD_DEFAULT);
echo ("$hash2<hr>");

if (password_verify("123456", $hash)) {
    echo ("ok<hr>");
}

$a = "/\d{10}/";
echo(preg_match($a,"123"));
echo("<hr>");
echo(preg_match($a,"1234567891"));
echo("<hr>");