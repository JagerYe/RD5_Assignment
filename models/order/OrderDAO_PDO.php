<?php
require_once "{$_SERVER['DOCUMENT_ROOT']}/PID_Assignment/models/order/OrderDAO_Interface.php";
require_once "{$_SERVER['DOCUMENT_ROOT']}/PID_Assignment/models/orderDetail/OrderDetailService.php";
require_once "{$_SERVER['DOCUMENT_ROOT']}/PID_Assignment/models/config.php";
class OrderDAO_PDO implements OrderDAO
{

    private $_strInsert = "INSERT INTO `orders`(`userID`, `orderDate`) VALUES (:userID,:orderDate);";
    private $_strUpdate = "UPDATE `orders` SET `userID`=:userID,`orderDate`=:orderDate WHERE `orderID`=:orderID;";
    private $_strDelete = "DELETE FROM `orders` WHERE `orderID`=:orderID;";
    private $_strCheckOrderExist = "SELECT COUNT(*) FROM `orders` WHERE `orderID`=:orderID;";
    private $_strGetAll = "SELECT `orderID`, `userID`, `orderDate`, ( SELECT SUM( `orderCommodityPrice` * `orderCommodityQuantity`) FROM `orderDetails` AS od WHERE od.`orderID` = o.`orderID`) AS total FROM `orders` AS o ORDER BY `orderDate` DESC;";
    private $_strGetOne = "SELECT `orderID`, `userID`, `orderDate`, ( SELECT SUM( `orderCommodityPrice` * `orderCommodityQuantity`) FROM `orderDetails` AS od WHERE od.`orderID` = o.`orderID`) AS total FROM `orders` AS o WHERE `orderID`=:orderID ORDER BY `orderDate` DESC;";
    private $_strGetUserID = "SELECT `orderID`, `userID`, `orderDate`, ( SELECT SUM( `orderCommodityPrice` * `orderCommodityQuantity`) FROM `orderDetails` AS od WHERE od.`orderID` = o.`orderID`) AS total FROM `orders` AS o WHERE `userID`=:userID ORDER BY `orderDate` DESC ;";

    //新增
    public function insertOrder($userID, $orderDate, $orderDetails)
    {
        try {
            $dbh = (new Config)->getDBConnect();
            $dbh->beginTransaction();
            $sth = $dbh->prepare($this->_strInsert);
            $sth->bindParam("userID", $userID);
            $sth->bindParam("orderDate", $orderDate);
            $sth->execute();
            $id = $dbh->lastInsertId();
            if (!(((new OrderDetailService())->getDAO())->insertManyOrderDetailByObjects($orderDetails, $id, $dbh))) {
                throw new Exception("找不到");
            }
            $dbh->commit();
            $sth = null;
        } catch (Exception $err) {
            $dbh->rollBack();
            $dbh = null;
            return false;
        }
        $dbh = null;
        return $id;
    }

    public function insertBlankOrder($userID, $orderDate)
    {
        try {
            $dbh = (new Config)->getDBConnect();
            $dbh->beginTransaction();
            $sth = $dbh->prepare($this->_strInsert);
            $sth->bindParam("userID", $userID);
            $sth->bindParam("orderDate", $orderDate);
            $sth->execute();
            $dbh->commit();
            $id = $dbh->lastInsertId();
            $sth = null;
        } catch (PDOException $err) {
            $dbh->rollBack();
            return false;
        }
        $dbh = null;
        return $id;
    }

    //新增 用物件
    public function insertOrderByObj($order, $orderDetails)
    {
        return $this->insertOrder(
            $order->getUserID(),
            $order->getOrderDate(),
            $orderDetails
        );
    }

    public function insertBlankOrderByObj($order)
    {
        return $this->insertBlankOrder(
            $order->getUserID(),
            $order->getOrderDate()
        );
    }

    //更新會員
    public function updateOrder($order)
    {
        try {
            $dbh = (new Config)->getDBConnect();
            $dbh->beginTransaction();
            $sth = $dbh->prepare($this->_strUpdate);
            $sth->bindParam("orderID", $order->getorderID());
            $sth->bindParam("userID", $order->getUserID());
            $sth->bindParam("orderDate", $order->getOrderDate());
            $sth->execute();
            $id = $dbh->lastInsertId();
            $dbh->commit();
            $sth = null;
        } catch (PDOException $err) {
            $dbh->rollBack();
            return false;
        }
        $dbh = null;
        return $id;
    }

    //之後需增加檢查是否有訂單
    public function deleteOrderByID($id)
    {
        try {
            $dbh = (new Config)->getDBConnect();
            $dbh->beginTransaction();
            $sth = $dbh->prepare($this->_strCheckOrderExist);
            $sth->bindParam("orderID", $id);
            $sth->execute();
            $request = $sth->fetch(PDO::FETCH_NUM);
            if ($request['0'] <= 0) {
                throw new Exception("找不到");
            }
            $sth = $dbh->prepare($this->_strDelete);
            $sth->bindParam("orderID", $id);
            $sth->execute();
            $dbh->commit();
            $sth = null;
        } catch (Exception $err) {
            $dbh->rollBack();
            return false;
        }
        $dbh = null;
        return true;
    }

    public function getAllOrders()
    {
        try {
            $dbh = (new Config)->getDBConnect();
            $sth = $dbh->query($this->_strGetAll);
            $request = $sth->fetchAll(PDO::FETCH_ASSOC);
            foreach ($request as $item) {
                $orders[] = new Order(
                    $item['orderID'],
                    $item['userID'],
                    $item['orderDate'],
                    $item['total']
                );
            }
            $sth = null;
        } catch (PDOException $err) {
            $dbh->rollBack();
            return false;
        }
        $dbh = null;
        return $orders;
    }
    public function getOneOrderByID($id)
    {
        try {
            $dbh = (new Config)->getDBConnect();
            $sth = $dbh->prepare($this->_strGetOne);
            $sth->bindParam("orderID", $id);
            $sth->execute();
            $request = $sth->fetch(PDO::FETCH_ASSOC);

            $order = new Order(
                $request['orderID'],
                $request['userID'],
                $request['orderDate'],
                $request['total']
            );

            $sth = null;
        } catch (PDOException $err) {
            return false;
        }
        $dbh = null;
        return $order;
    }

    public function getOrderByUserID($id)
    {
        try {
            $dbh = (new Config)->getDBConnect();
            $sth = $dbh->prepare($this->_strGetUserID);
            $sth->bindParam("userID", $id);
            $sth->execute();
            $request = $sth->fetchAll(PDO::FETCH_ASSOC);
            foreach ($request as $item) {
                $orders[] = new Order(
                    $item['orderID'],
                    $item['userID'],
                    $item['orderDate'],
                    $item['total']
                );
            }
            $sth = null;
        } catch (PDOException $err) {
            $dbh->rollBack();
            return false;
        }
        $dbh = null;
        return $orders;
    }
}
