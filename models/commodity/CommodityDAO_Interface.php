<?php
interface CommodityDAO
{
    public function insertCommodity($name, $price, $quantity, $status, $text);
    public function updateCommodity($commodity);
    public function deleteCommodityByID($id);
    public function getOneCommodityByID($id);
    public function getAllCommoditys();
    public function getCheckAndTotal($id, $quantity);
}
