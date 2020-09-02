<?php

class Controller
{
    public function getJsonToModel($model, $jsonStr, $isInsert = false)
    {
        require_once "{$_SERVER['DOCUMENT_ROOT']}/RD5_Assignment/models/$model/$model.php";
        return $model::jsonStringToModel($jsonStr, $isInsert);
    }

    public function getJsonArrToModelsArr($model, $jsonStr, $isInsert = false)
    {
        require_once "{$_SERVER['DOCUMENT_ROOT']}/RD5_Assignment/models/$model/$model.php";
        return $model::jsonArrayStringToModelsArray($jsonStr, $isInsert);
    }
}
