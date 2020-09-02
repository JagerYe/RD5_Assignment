<?php
class OrderController extends Controller
{
    private $_dao;
    public function __construct()
    {
        require_once "{$_SERVER['DOCUMENT_ROOT']}/PID_Assignment/models/order/OrderService.php";
        require_once "{$_SERVER['DOCUMENT_ROOT']}/PID_Assignment/models/commodity/CommodityService.php";
        require_once "{$_SERVER['DOCUMENT_ROOT']}/PID_Assignment/controllers/OrderDetailController.php";
        $this->_dao = (new OrderService())->getDAO();
        $this->model("order");
        $this->model("orderDetail");
        $this->model("commodity");
    }

    private function jsonToModel($str)
    {
        $obj = json_decode($str);
        try {
            $order = new Order(
                $obj->_userID,
                $obj->_userName,
                $obj->_userEmail
            );
        } catch (Exception $err) {
            return false;
        }

        return $order;
    }

    public function insert($userID, $orderDate, $detailsStr)
    {
        try {
            new Order("???", $userID, $orderDate);
        } catch (Exception $err) {
            return false;
        }
        $orderDetails = (new OrderDetailController())->jsonToModel($detailsStr);

        if ($id = $this->_dao->insertOrder($userID, $orderDate, $orderDetails)) {
            $order = $this->getOne($id, true);
            return $order;
        }
        return false;
    }

    public function insertByObj($order, $orderDetails)
    {
        if ($id = $this->_dao->insertOrderByObj($order, $orderDetails)) {
            return true;
        }

        return false;
    }

    public function update($str)
    {
        if (!($order = $this->jsonToModel($str))) {
            return false;
        }

        if ($id = $this->_dao->updateOrder($order)) {
            $order = $this->getOne($id, true);
            return $order;
        }
        return false;
    }

    // public function delete($id)
    // {
    //     if ($this->_dao->deleteOrderByID($id)) {
    //         return true;
    //     }
    //     return false;
    // }

    public function getAll()
    {
        if ($orders = $this->_dao->getAllOrders()) {
            return json_encode($orders);
        }
        return false;
    }

    public function getOne($id=1, $attention = false)
    {
        if ($order = $this->_dao->getOneOrderByID($id)) {
            $order->setOrderAttention($attention);
            return json_encode($order);
        }
        return false;
    }

    public function getUserOrder()
    {
        if (!isset($_SESSION['userID'])) {
            return false;
        }
        if ($orders = $this->_dao->getOrderByUserID($_SESSION['userID'])) {
            return json_encode($orders);
        }
        return false;
    }

    public function checkout($date)
    {
        if (!isset($_SESSION['userName'])) {
            return false;
        }
        $jsonArr = json_decode($_SESSION['shoppingCart']);
        $cdao = (new CommodityService())->getDAO();
        foreach ($jsonArr as $jsonObj) {
            $commodity = $cdao->getOneCommodityByID($jsonObj->_commodityID);
            $item = new OrderDetail(
                "???",
                $jsonObj->_commodityID,
                $commodity->getCommodityPrice(),
                $jsonObj->_buyQuantity,
                $commodity->getCommodityName()
            );
            $orderDate[] = $item;
        }
        $order = new Order("???", $_SESSION['userID'], $date);
        if ($order = $this->insertByObj($order, $orderDate)) {
            unset($_SESSION['shoppingCart']);
            return $order;
        } else {
            return false;
        }
    }
}
