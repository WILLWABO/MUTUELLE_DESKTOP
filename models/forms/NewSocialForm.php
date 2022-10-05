<?php

namespace app\models\forms;


use yii\base\Model;

class NewSocialForm extends Model
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
            [['member_id','session_id','amount'],'integer','min' => 1],
            ['amount','integer','min' => 0,'message' => 'Ce champ attend un entier positif']
        ];
    }
}