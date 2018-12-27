<?php
/**
 * Created by PhpStorm.
 * User: medric
 * Date: 26/12/18
 * Time: 13:41
 */

namespace app\models\forms;


use yii\base\Model;

class NewMemberForm extends Model
{
    public $username;
    public $name;
    public $first_name;
    public $tel;
    public $email;
    public $avatar;
    public $password;

    public function rules()
    {
        return [
            [['username','name','first_name','tel','password'],'string'],
            [['username','name','first_name','tel','password','email'],'required'],
            [['email'],'email'],
            [['avatar'],'image','isEmpty' => false],
        ];
    }
}