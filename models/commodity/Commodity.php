<?php
class Commodity implements \JsonSerializable
{
    private $_commodityID;
    private $_commodityName;
    private $_commodityPrice;
    private $_commodityQuantity;
    private $_commodityStatus;
    private $_commodityText;
    private $_commodityImage;

    public function __construct(
        $commodityID,
        $commodityName,
        $commodityPrice,
        $commodityQuantity,
        $commodityStatus,
        $commodityText = "",
        $commodityImage = null
    ) {
        $this->setCommodityID($commodityID);
        $this->setCommodityName($commodityName);
        $this->setCommodityPrice($commodityPrice);
        $this->setCommodityQuantity($commodityQuantity);
        $this->setCommodityStatus($commodityStatus);
        $this->setCommodityText($commodityText);
        $this->setCommodityImage($commodityImage);
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

    public function getCommodityName()
    {
        return $this->_commodityName;
    }
    public function setCommodityName($commodityName)
    {
        if ($commodityName === null || $commodityName == "") {
            throw new Exception("名稱格式錯誤");
        }
        $this->_commodityName = $commodityName;
        return true;
    }

    public function getCommodityPrice()
    {
        return $this->_commodityPrice;
    }
    public function setCommodityPrice($commodityPrice)
    {
        if (!is_numeric($commodityPrice) || $commodityPrice < 0) {
            throw new Exception("價格格式錯誤");
        }
        $this->_commodityPrice = $commodityPrice;
        return true;
    }

    public function getCommodityQuantity()
    {
        return $this->_commodityQuantity;
    }
    public function setCommodityQuantity($commodityQuantity)
    {
        if (!is_numeric($commodityQuantity) || $commodityQuantity < 0) {
            throw new Exception("數量格式錯誤");
        }
        $this->_commodityQuantity = $commodityQuantity;
        return true;
    }

    public function getCommodityStatus()
    {
        return $this->_commodityStatus;
    }
    public function setCommodityStatus($commodityStatus)
    {
        if ($commodityStatus === null ||  ($commodityStatus != "open" && $commodityStatus != "close")) {
            throw new Exception("狀態格式錯誤");
        }
        $this->_commodityStatus = $commodityStatus;
        return true;
    }

    public function getCommodityText()
    {
        return $this->_commodityText;
    }
    public function setCommodityText($commodityText)
    {
        $this->_commodityText = $commodityText;
        return true;
    }

    public function getCommodityImage()
    {
        return $this->_commodityImage;
    }
    public function setCommodityImage($commodityImage)
    {
        $this->_commodityImage = $commodityImage;
        return true;
    }

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }

    public function showData()
    {
        echo ("<br>");
        echo ("ID:" . $this->getcommodityID() . "<br>");
        echo ("Name:" . $this->getCommodityName() . "<br>");
        echo ("Price:" . $this->getCommodityPrice() . "<br>");
        echo ("Quantity:" . $this->getCommodityQuantity() . "<br>");
        echo ("Status:" . $this->getCommodityStatus() . "<br>");
        echo ("Text:" . $this->getCommodityText() . "<br>");
        echo ("Password:" . $this->getCommodityImage() . "<br>");
    }
}
