<?php
class ShoppingCartController extends Controller
{
    private $_dao;
    public function __construct()
    {
        $this->model("shoppingCart");
    }

    private function jsonToModel($str)
    {
        $obj = json_decode($str);
        try {
            $shoppingCart = new ShoppingCart(
                $obj->_commodityID,
                $obj->_buyQuantity
            );
        } catch (Exception $err) {
            return false;
        }

        return $shoppingCart;
    }

    public function addByObj($str)
    {
        if (!($newItem = $this->jsonToModel($str))) {
            return false;
        }
        $updata = false;
        if (isset($_SESSION['shoppingCart'])) {
            $jsonObj = json_decode($_SESSION['shoppingCart']);
            foreach ($jsonObj as $obj) {
                $item = new ShoppingCart($obj->_commodityID, $obj->_buyQuantity);
                if ($item->getCommodityID() == $newItem->getCommodityID()) {
                    $item->setBuyQuantity($item->getBuyQuantity() + $newItem->getBuyQuantity());
                    $updata = true;
                }
                $shoppingCart[] = $item;
            }
        }

        if (!$updata) {
            $shoppingCart[] = $newItem;
        }

        $_SESSION['shoppingCart'] = json_encode($shoppingCart);

        return count($shoppingCart);
    }

    public function updateByObj($str)
    {

        if (!($updataItem = $this->jsonToModel($str))) {
            return false;
        }

        if (isset($_SESSION['shoppingCart'])) {
            $jsonObj = json_decode($_SESSION['shoppingCart']);
            foreach ($jsonObj as $obj) {
                $item = new ShoppingCart($obj->_commodityID, $obj->_buyQuantity);
                if ($item->getCommodityID() == $updataItem->getCommodityID()) {
                    $item->setBuyQuantity($updataItem->getBuyQuantity());
                }
                $shoppingCart[] = $item;
            }
            $_SESSION['shoppingCart'] = json_encode($shoppingCart);
            return true;
        }
        return false;
    }

    public function delete($id)
    {
        $result = false;
        if (isset($_SESSION['shoppingCart'])) {
            $jsonObj = json_decode($_SESSION['shoppingCart']);
            foreach ($jsonObj as $obj) {
                $item = new ShoppingCart($obj->_commodityID, $obj->_buyQuantity);
                if ($item->getCommodityID() == $id) {
                    $result = true;
                    continue;
                }
                $shoppingCart[] = $item;
            }
        }

        if ($result) {
            $_SESSION['shoppingCart'] = json_encode($shoppingCart);
        }

        return $result;
    }

    public function getAll()
    {
        if (!isset($_SESSION['shoppingCart'])) {
            return false;
        }

        require_once "{$_SERVER['DOCUMENT_ROOT']}/PID_Assignment/models/commodity/CommodityService.php";
        $commodityDAO = (new CommodityService)->getDAO();
        $jsonArr = json_decode($_SESSION['shoppingCart']);
        $total = 0;
        $errMassege = "";
        foreach ($jsonArr as $jsonObj) {
            $id = $jsonObj->_commodityID;
            $quantity = $jsonObj->_buyQuantity;
            $item = new ShoppingCart($id, $quantity);
            $request = $commodityDAO->getCheckAndTotal($id, $quantity);
            if (!($request['0'])) {
                $errMassege = "商品狀態有問題";
                continue;
            }
            $total += $request['1'];
            $shoppingCart[] = $item;
        }
        $resultData = [
            'shoppingCart' => $shoppingCart,
            'total' => $total,
            'errMassege' => $errMassege
        ];

        return json_encode($resultData);
    }
}
