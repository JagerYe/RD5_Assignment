<?php

require_once "{$_SERVER['DOCUMENT_ROOT']}/PID_Assignment/models/orderDetail/OrderDetail.php";
require_once "{$_SERVER['DOCUMENT_ROOT']}/PID_Assignment/models/orderDetail/OrderDetailService.php";

$orderDetail01 = new OrderDetail(1, 1, 111, 222);
$orderDetail02 = new OrderDetail(1, 2, 333, 444);
$orderDetailDAO = (new OrderDetailService())->getDAO();

//新增測試----------------------------------------
$orderDetailDAO->insertOrderDetail(
    $orderDetail01->getOrderID(),
    $orderDetail01->getCommodityID(),
    $orderDetail01->getOrderCommodityPrice(),
    $orderDetail01->getOrderCommodityQuantity()
);
$orderDetailDAO->insertOrderDetailByObj($orderDetail02);
echo ("<hr>");
//新增測試----------------------------------------

//更新測試----------------------------------------
$orderDetail02->setOrderID(3);
$orderDetail02->setCommodityID(1);
if ($orderDetailDAO->updateOrderDetail($orderDetail02, 1, 2)) {
    echo ("OK");
} else {
    echo ("no");
}
echo ("<hr>");
//更新測試----------------------------------------

//刪除測試----------------------------------------
if ($orderDetailDAO->deleteOrderDetailByID($orderDetail02->getOrderID(), $orderDetail02->getCommodityID())) {
    echo ("OK");
} else {
    echo ("no");
}
echo ("<hr>");
//刪除測試----------------------------------------

//取得所有測試----------------------------------------
$orderDetails = $orderDetailDAO->getAllOrderDetails();
var_dump($orderDetails);

//此方法會讓$item得不到member的class
// foreach ($members as $item) {
//     var_dump($item);
//     $item->showDate();
// }

for ($i = 0; $i < count($orderDetails); $i++) {
    $orderDetails[$i]->showData();
}
echo ("<hr>");
//取得所有測試----------------------------------------

//取得指定會員測試----------------------------------------
$orderDetail03 = $orderDetailDAO->getOneOrderDetailByID(1, 4);
echo ($orderDetail03->showData());
echo ("<hr>");
//取得指定會員測試----------------------------------------