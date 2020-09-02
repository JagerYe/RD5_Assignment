<?php
session_start();
require_once "{$_SERVER['DOCUMENT_ROOT']}/RD5_Assignment/core/api.php";
require_once "{$_SERVER['DOCUMENT_ROOT']}/RD5_Assignment/core/Controller.php";

try {
    $api = new Api();
} catch (Exception $err) {
    return false;
}
