<?php
class CommodityController extends Controller
{
    private $_dao;
    public function __construct()
    {
        require_once "{$_SERVER['DOCUMENT_ROOT']}/PID_Assignment/models/commodity/CommodityService.php";
        $this->_dao = (new CommodityService())->getDAO();
        $this->model("commodity");
    }

    private function jsonToModel($str)
    {
        $obj = json_decode($str);
        try {
            $commodity = new Commodity(
                $obj->_commodityID,
                $obj->_commodityName,
                $obj->_commodityPrice,
                $obj->_commodityQuantity,
                $obj->_commodityStatus,
                $obj->_commodityText
            );
        } catch (Exception $err) {
            return false;
        }

        return $commodity;
    }

    // public function insert($id, $password, $name, $email, $phone, $status)
    // {
    //     if ($password == null || strlen($password) <= 0) {
    //         return false;
    //     }

    //     if ($this->_dao->insertCommodity($id, $password, $name, $email, $phone, $status)) {
    //         return true;
    //     }
    //     return false;
    // }

    public function insertByObj($str)
    {

        if (!($commodity = $this->jsonToModel($str))) {
            return false;
        }

        if ($id = $this->_dao->insertCommodityByObj($commodity)) {
            return $id;
        }

        return false;
    }

    public function update($str)
    {
        if (!($commodity = $this->jsonToModel($str))) {
            return false;
        }

        if ($this->_dao->updateCommodity($commodity)) {
            return true;
        }
        return false;
    }

    public function delete($id)
    {
        if ($this->_dao->deleteCommodityByID($id)) {
            return true;
        }
        return false;
    }

    public function getAll()
    {
        if ($commoditys = $this->_dao->getAllCommoditys()) {
            return json_encode($commoditys);
        }
        return false;
    }

    public function getOne($id)
    {
        if ($commodity = $this->_dao->getOneCommodityByID($id)) {
            return json_encode($commodity);
        }
        return false;
    }
}
