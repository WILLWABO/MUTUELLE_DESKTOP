<?php

namespace app\models\forms;


use yii\base\Model;

class NewTontineForm extends Model
{
    public $member_id;
    public $amount;
    public $session_id;
    public $categorie_id;


    public function attributeLabels()
    {
        return [
            'amount' => 'Montant',

        ];
    }

    public function rules()
    {
        return [
            [['member_id','amount','session_id','categorie_id' ],'required','message' => 'Ce champ est obligatoire'],
            [['member_id','session_id','categorie_id'],'integer','min' => 0],
            ['amount','integer','min' => 0,'message' => 'Ce champ attend un entier positif']
        ];
    }
}