<?php

require_once "{$_SERVER['DOCUMENT_ROOT']}/PID_Assignment/models/order/Order.php";
require_once "{$_SERVER['DOCUMENT_ROOT']}/PID_Assignment/models/orderDetail/orderDetail.php";
require_once "{$_SERVER['DOCUMENT_ROOT']}/PID_Assignment/models/order/OrderService.php";

$order = new Order("??", "a02", "2020-08-08 00:01:02");
$orderDetails[] = new OrderDetail("???", 1, 111, 222);
$orderDetails[] = new OrderDetail("???", 2, 222, 222);
$orderDetails[] = new OrderDetail("???", 3, 333, 222);
$orderDAO = (new OrderService())->getDAO();

//新增測試----------------------------------------
if($orderDAO->insertOrder($order->getUserID(), $order->getOrderDate(), $orderDetails)){
    echo("ok");
}else{
    echo("no");
}
echo ("<hr>");
//新增測試----------------------------------------
