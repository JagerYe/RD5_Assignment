<?php
class OrderDetail implements \JsonSerializable
{
    private $_orderID;
    private $_commodityID;
    private $_commodityName;
    private $_orderCommodityPrice;
    private $_orderCommodityQuantity;

    public function __construct(
        $orderID,
        $commodityID,
        $orderCommodityPrice,
        $orderCommodityQuantity,
        $commodityName = ""
    ) {
        $this->setOrderID($orderID);
        $this->setCommodityID($commodityID);
        $this->setOrderCommodityPrice($orderCommodityPrice);
        $this->setOrderCommodityQuantity($orderCommodityQuantity);
        $this->setCommodityName($commodityName);
    }

    public function getOrderID()
    {
        return $this->_orderID;
    }
    public function setOrderID($orderID)
    {
        $this->_orderID = $orderID;
        return true;
    }

    public function getCommodityID()
    {
        return $this->_commodityID;
    }
    public function setCommodityID($commodityID)
    {
        if ($commodityID == null || $commodityID == "") {
            throw new Exception("商品ID格式錯誤");
        }
        $this->_commodityID = $commodityID;
        return true;
    }

    public function getCommodityName()
    {
        return $this->_commodityName;
    }
    public function setCommodityName($commodityName)
    {
        $this->_commodityName = $commodityName;
        return true;
    }

    public function getOrderCommodityPrice()
    {
        return $this->_orderCommodityPrice;
    }
    public function setOrderCommodityPrice($orderCommodityPrice)
    {
        if ($orderCommodityPrice == null || !is_numeric($orderCommodityPrice) || $orderCommodityPrice < 0) {
            throw new Exception("價格格式錯誤");
        }
        $this->_orderCommodityPrice = $orderCommodityPrice;
        return true;
    }

    public function getOrderCommodityQuantity()
    {
        return $this->_orderCommodityQuantity;
    }
    public function setOrderCommodityQuantity($orderCommodityQuantity)
    {
        if ($orderCommodityQuantity == null || !is_numeric($orderCommodityQuantity) || $orderCommodityQuantity < 0) {
            throw new Exception("數量格式錯誤");
        }
        $this->_orderCommodityQuantity = $orderCommodityQuantity;
        return true;
    }

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }

    public function showData()
    {
        echo ("<br>");
        echo ("OrderID:" . $this->getOrderID() . "<br>");
        echo ("CommodityID:" . $this->getCommodityID() . "<br>");
        echo ("OrderCommodityPrice:" . $this->getOrderCommodityPrice() . "<br>");
        echo ("OrderCommodityQuantity:" . $this->getOrderCommodityQuantity() . "<br>");
    }
}
