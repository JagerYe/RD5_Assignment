<?php

require_once "{$_SERVER['DOCUMENT_ROOT']}/PID_Assignment/models/order/Order.php";
require_once "{$_SERVER['DOCUMENT_ROOT']}/PID_Assignment/models/order/OrderService.php";

$order01 = new Order("??", "a02", "2020-08-08 00:01:02");
$order02 = new Order("??", "a03", "2020-08-09 00:01:02");
$orderDAO = (new OrderService())->getDAO();

//新增測試----------------------------------------
$orderDAO->insertBlankOrder(
    $order01->getUserID(),
    $order01->getOrderDate()
);
$orderDAO->insertBlankOrderByObj($order02);
echo ("<hr>");
//新增測試----------------------------------------

//更新測試----------------------------------------
$order02->setOrderID("3");
$id = $orderDAO->updateOrder($order02);
if (strlen($id) > 0) {
    echo ("OK");
} else {
    echo ("no");
}
echo ("<hr>");
//更新測試----------------------------------------

//刪除測試----------------------------------------
if ($orderDAO->deleteOrderByID(8)) {
    echo ("OK");
} else {
    echo ("no");
}
echo ("<hr>");
//刪除測試----------------------------------------

//取得所有測試----------------------------------------
$orders = $orderDAO->getAllOrders();
var_dump($orders);

//此方法會讓$item得不到member的class
// foreach ($members as $item) {
//     var_dump($item);
//     $item->showDate();
// }

for ($i = 0; $i < count($orders); $i++) {
    $orders[$i]->showData();
}
echo ("<hr>");
//取得所有測試----------------------------------------

//取得指定會員測試----------------------------------------
$order03 = $orderDAO->getOneOrderByID(1);
echo ($order03->showData());
echo ("<hr>");
//取得指定會員測試----------------------------------------