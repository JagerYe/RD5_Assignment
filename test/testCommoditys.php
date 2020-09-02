<?php

require_once "{$_SERVER['DOCUMENT_ROOT']}/PID_Assignment/models/commodity/Commodity.php";
require_once "{$_SERVER['DOCUMENT_ROOT']}/PID_Assignment/models/commodity/CommodityService.php";

$commoditys01 = new Commodity("??", "111", 111, 222, "close", "333");
$commoditys02 = new Commodity("??", "111", 111, 222, "close", "333");
$commoditysDAO = (new CommodityService())->getDAO();

//新增測試----------------------------------------
$commoditysDAO->insertCommodity(
    $commoditys01->getCommodityName(),
    $commoditys01->getCommodityPrice(),
    $commoditys01->getCommodityQuantity(),
    $commoditys01->getCommodityStatus(),
    $commoditys01->getCommodityText()
);
$commoditysDAO->insertCommodityByObj($commoditys02);
echo ("<hr>");
//新增測試----------------------------------------

//更新測試----------------------------------------
$commoditys02->setCommodityID("13");
if ($commoditysDAO->updateCommodity($commoditys02)) {
    echo ("OK");
} else {
    echo ("no");
}
echo ("<hr>");
//更新測試----------------------------------------

//刪除測試----------------------------------------
if ($commoditysDAO->deleteCommodityByID($commoditys02->getCommodityID())) {
    echo ("OK");
} else {
    echo ("no");
}
echo ("<hr>");
//刪除測試----------------------------------------

//取得所有測試----------------------------------------
$commodityss = $commoditysDAO->getAllCommoditys();
var_dump($commodityss);

//此方法會讓$item得不到member的class
// foreach ($members as $item) {
//     var_dump($item);
//     $item->showDate();
// }

for ($i = 0; $i < count($commodityss); $i++) {
    $commodityss[$i]->showData();
}
echo ("<hr>");
//取得所有測試----------------------------------------

//取得指定會員測試----------------------------------------
$commoditys03 = $commoditysDAO->getOneCommodityByID("10");
echo ($commoditys03->showData());
echo ("<hr>");
//取得指定會員測試----------------------------------------