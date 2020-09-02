<?php
class ShoppingCart implements \JsonSerializable
{
    private $_commodityID;
    private $_buyQuantity;

    public function __construct($commodityID, $buyQuantity)
    {
        $this->setCommodityID($commodityID);
        $this->setBuyQuantity($buyQuantity);
    }

    public function getCommodityID()
    {
        return $this->_commodityID;
    }
    public function setCommodityID($commodityID)
    {
        if ($commodityID === null || $commodityID == "") {
            throw new Exception("ID格式錯誤");
        }
        $this->_commodityID = $commodityID;
        return true;
    }

    public function getBuyQuantity()
    {
        return $this->_buyQuantity;
    }
    public function setBuyQuantity($buyQuantity)
    {
        if ($buyQuantity === null || !is_numeric($buyQuantity) || $buyQuantity <= 0) {
            throw new Exception("數量格式錯誤");
        }
        $this->_buyQuantity = $buyQuantity;
        return true;
    }

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}
