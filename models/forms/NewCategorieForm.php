<?php

namespace app\models\forms;


use yii\base\Model;

class NewCategorieForm extends Model
{
    public $member_id;
    public $amount;
    public $session_id;

    public function attributeLabels()
    {
        return [
            'amount' => 'Montant',

        ];
    }

    public function rules()
    {
        return [
            [['member_id','amount','session_id' ],'required','message' => 'Ce champ est obligatoire'],
            [['member_id','session_id'],'integer','min' => 0],
            ['amount','integer','min' => 0,'message' => 'Ce champ attend un entier positif']
        ];
    }
}