<?php
interface OrderDAO
{
    public function insertOrder($userID, $orderDate, $orderDetails);
    public function insertBlankOrder($userID, $orderDate);
    public function updateOrder($order);
    public function deleteOrderByID($id);
    public function getOneOrderByID($id);
    public function getAllOrders();
    public function getOrderByUserID($id);
}
