<?php

class Controller
{
    public function model($model)
    {
        require_once "{$_SERVER['DOCUMENT_ROOT']}/RD5_Assignment/models/$model/$model.php";
    }
}
