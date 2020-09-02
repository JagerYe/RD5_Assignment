<?php
require_once "{$_SERVER['DOCUMENT_ROOT']}/PID_Assignment/models/orderDetail/OrderDetailDAO_Interface.php";
require_once "{$_SERVER['DOCUMENT_ROOT']}/PID_Assignment/models/config.php";
class OrderDetailDAO_PDO implements OrderDetailDAO
{

    private $_strInsert = "INSERT INTO `orderdetails`(`orderID`, `commodityID`, `orderCommodityPrice`, `orderCommodityQuantity`) VALUES (:orderID,:commodityID,:orderCommodityPrice,:orderCommodityQuantity);";
    private $_strInsertManyBase = "INSERT INTO `orderdetails`(`orderID`, `commodityID`, `orderCommodityPrice`, `orderCommodityQuantity`) VALUES";
    private $_strUpdate = "UPDATE `orderdetails` SET `orderID`=:orderID,`commodityID`=:commodityID,`orderCommodityPrice`=:orderCommodityPrice,`orderCommodityQuantity`=:orderCommodityQuantity WHERE `orderID`=:oldOrderID and `commodityID`=:oldCommodityID;";
    private $_strDelete = "DELETE FROM `orderdetails` WHERE `orderID`=:orderID and `commodityID`=:commodityID;";
    private $_strCheckOrderDetailExist = "SELECT COUNT(*) FROM `orderdetails` WHERE `orderID`=:orderID and `commodityID`=:commodityID;";
    private $_strGetAll = "SELECT `orderID`, o.`commodityID`, `commodityName`, `orderCommodityPrice`, `orderCommodityQuantity` FROM `orderdetails` AS o INNER JOIN `commoditys` AS c ON o.`commodityID`=c.`commodityID`;";
    private $_strGetOne = "SELECT `orderID`, o.`commodityID`, `commodityName`, `orderCommodityPrice`, `orderCommodityQuantity` FROM `orderdetails` AS o INNER JOIN `commoditys` AS c ON o.`commodityID`=c.`commodityID` WHERE `orderID`=:orderID and `commodityID`=:commodityID;";
    private $_strGetByOrderID = "SELECT `orderID`, o.`commodityID`, `commodityName`, `orderCommodityPrice`, `orderCommodityQuantity` FROM `orderdetails` AS o INNER JOIN `commoditys` AS c ON o.`commodityID`=c.`commodityID` WHERE `orderID`=:orderID;";

    //新增
    public function insertOrderDetail($orderID, $commodityID, $price, $quantity)
    {
        try {
            $dbh = (new Config)->getDBConnect();
            $dbh->beginTransaction();
            $sth = $dbh->prepare($this->_strInsert);
            $sth->bindParam("orderID", $orderID);
            $sth->bindParam("commodityID", $commodityID);
            $sth->bindParam("orderCommodityPrice", $price);
            $sth->bindParam("orderCommodityQuantity", $quantity);
            $sth->execute();
            $dbh->commit();
            $sth = null;
        } catch (PDOException $err) {
            $dbh->rollBack();
            return false;
        }
        $dbh = null;
        return true;
    }

    //新增 用物件
    public function insertOrderDetailByObj($orderDetail)
    {
        return $this->insertOrderDetail(
            $orderDetail->getOrderID(),
            $orderDetail->getCommodityID(),
            $orderDetail->getOrderCommodityPrice(),
            $orderDetail->getOrderCommodityQuantity()
        );
    }

    //新增多數清單
    public function insertManyOrderDetailByObjects($orderDetails, $orderID, $dbh)
    {
        for ($i = 0; $i < count($orderDetails); $i++) {
            $this->_strInsertManyBase .= "(:orderID{$i},:commodityID{$i},:orderCommodityPrice{$i},:orderCommodityQuantity{$i})";
            if ($i < (count($orderDetails) - 1)) {
                $this->_strInsertManyBase .= ",";
            }
        }
        try {
            $sth = $dbh->prepare($this->_strInsertManyBase);
            foreach ($orderDetails as $key => $item) {
                $sth->bindParam("orderID$key", $orderID);
                $sth->bindParam("commodityID$key", $item->getCommodityID());
                $sth->bindParam("orderCommodityPrice$key", $item->getOrderCommodityPrice());
                $sth->bindParam("orderCommodityQuantity$key", $item->getOrderCommodityQuantity());
            }
            $sth->execute();
            $sth = null;
        } catch (PDOException $err) {
            throw new Exception("找不到");
        }
        return true;
    }

    //更新
    public function updateOrderDetail($orderDetail, $oldOrderID, $oldCommodityID)
    {
        try {
            $dbh = (new Config)->getDBConnect();
            $dbh->beginTransaction();
            $sth = $dbh->prepare($this->_strUpdate);
            $sth->bindParam("orderID", $orderDetail->getOrderID());
            $sth->bindParam("commodityID", $orderDetail->getCommodityID());
            $sth->bindParam("orderCommodityPrice", $orderDetail->getOrderCommodityPrice());
            $sth->bindParam("orderCommodityQuantity", $orderDetail->getOrderCommodityQuantity());
            $sth->bindParam("oldOrderID", $oldOrderID);
            $sth->bindParam("oldCommodityID", $oldCommodityID);
            $sth->execute();
            $dbh->commit();
            $sth = null;
        } catch (PDOException $err) {
            $dbh->rollBack();
            return false;
        }
        $dbh = null;
        return true;
    }

    public function deleteOrderDetailByID($orderID, $commodityID)
    {
        try {
            $dbh = (new Config)->getDBConnect();
            $dbh->beginTransaction();
            $sth = $dbh->prepare($this->_strCheckOrderDetailExist);
            $sth->bindParam("orderID", $orderID);
            $sth->bindParam("commodityID", $commodityID);
            $sth->execute();
            $request = $sth->fetch(PDO::FETCH_NUM);
            if ($request['0'] <= 0) {
                throw new Exception("找不到");
            }
            $sth = $dbh->prepare($this->_strDelete);
            $sth->bindParam("orderID", $orderID);
            $sth->bindParam("commodityID", $commodityID);
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

    public function getAllOrderDetails()
    {
        try {
            $dbh = (new Config)->getDBConnect();
            $sth = $dbh->query($this->_strGetAll);
            $request = $sth->fetchAll(PDO::FETCH_ASSOC);
            foreach ($request as $item) {
                $orderDetails[] = new OrderDetail(
                    $item['orderID'],
                    $item['commodityID'],
                    $item['orderCommodityPrice'],
                    $item['orderCommodityQuantity'],
                    $item['commodityName']
                );
            }
            $sth = null;
        } catch (PDOException $err) {
            $dbh->rollBack();
            echo ($err->__toString());
            return false;
        }
        $dbh = null;
        return $orderDetails;
    }

    public function getOneOrderDetailByID($orderID, $commodityID)
    {
        try {
            $dbh = (new Config)->getDBConnect();
            $sth = $dbh->prepare($this->_strGetOne);
            $sth->bindParam("orderID", $orderID);
            $sth->bindParam("commodityID", $commodityID);
            $sth->execute();
            $request = $sth->fetch(PDO::FETCH_ASSOC);
            echo ($request);

            $orderDetail = new OrderDetail(
                $request['orderID'],
                $request['commodityID'],
                $request['orderCommodityPrice'],
                $request['orderCommodityQuantity'],
                $request['commodityName']
            );

            $sth = null;
        } catch (PDOException $err) {
            echo ($err->__toString());
            return false;
        }
        $dbh = null;
        return $orderDetail;
    }

    public function getOrderDetailByOrderID($orderID)
    {
        try {
            $dbh = (new Config)->getDBConnect();
            $sth = $dbh->prepare($this->_strGetByOrderID);
            $sth->bindParam("orderID", $orderID);
            $sth->execute();
            $request = $sth->fetchAll(PDO::FETCH_ASSOC);
            foreach ($request as $item) {
                $orderDetails[] = new OrderDetail(
                    $item['orderID'],
                    $item['commodityID'],
                    $item['orderCommodityPrice'],
                    $item['orderCommodityQuantity'],
                    $item['commodityName']
                );
            }

            $sth = null;
        } catch (PDOException $err) {
            echo ($err->__toString());
            return false;
        }
        $dbh = null;
        return $orderDetails;
    }
}
