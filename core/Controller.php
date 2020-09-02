<?php

class Controller
{
    public function model($model)
    {
        require_once "{$_SERVER['DOCUMENT_ROOT']}/PID_Assignment/models/$model/$model.php";
    }
}
