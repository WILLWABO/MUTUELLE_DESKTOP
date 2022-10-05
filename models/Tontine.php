<?php

namespace app\models;


use yii\db\ActiveRecord;

class Tontine extends ActiveRecord
{
    public function administrator() {
        return Administrator::findOne($this->administrator_id);
    }
    public function session() {
        return Session::findOne($this->session_id);
    }
}