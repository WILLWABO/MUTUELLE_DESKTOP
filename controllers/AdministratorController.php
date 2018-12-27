<?php
/**
 * Created by PhpStorm.
 * User: medric
 * Date: 23/12/18
 * Time: 20:03
 */

namespace app\controllers;


use app\managers\FileManager;
use app\models\Administrator;
use app\models\forms\NewMemberForm;
use app\models\Member;
use app\models\User;
use yii\base\Module;
use yii\base\Security;
use yii\web\Controller;
use yii\web\UploadedFile;

class AdministratorController extends Controller
{
    public $layout = "administrator_base";
    public $user;
    public $administrator;
    public $defaultAction = "accueil";


    public function beforeAction($action)
    {

        if (!\Yii::$app->user->getIsGuest()) {

            $user = User::findOne(\Yii::$app->user->getId());


            if ($user->type ===  "ADMINISTRATOR") {
                $this->user = $user;
                $this->administrator = Administrator::findOne(['user_id'=> $user->id]);
                $this->view->params = ['user' => $this->user,'administrator' => $this->administrator];
                return parent::beforeAction($action); // TODO: Change the autogenerated stub
            }
            elseif ( $user->type === "MEMBER") {
                \Yii::$app->response->redirect("@member.home");
            }
            else
                \Yii::$app->end(404);
        }
        else {
            \Yii::$app->response->redirect("@guest.connection");
        }
    }



    public function actionAccueil() {
        return $this->render('home');
    }

    public function actionDeconnexion() {
        if (\Yii::$app->request->post()) {
            \Yii::$app->user->logout();
            return $this->redirect('@guest.connection');
        }
        return \Yii::$app->end(404);
    }

    public function actionMembres() {
        $members = Member::find()->all();
        return $this->render('members',compact('members'));
    }

    public function actionNouveauMembre() {
        $model = new NewMemberForm();
        return $this->render('new_member',['model'=> $model]);
    }

    public function actionAjouterMember() {
        if (\Yii::$app->request->post()) {
            $model = new NewMemberForm();

            if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
                if (!Member::findOne(['username' => $model->username]))
                {
                    $user = new User();
                    $user->name = $model->name;
                    $user->first_name = $model->first_name;
                    $user->tel = $model->tel;
                    $user->email = $model->email;
                    $user->type = "MEMBER";
                    $user->password = (new Security())->generatePasswordHash($model->password);
                    $user->avatar = FileManager::storeAvatar(UploadedFile::getInstance($model,'avatar'),$model->username,'MEMBER');
                    $user->save();


                    $member = new Member();
                    $member->administrator_id = $this->administrator->id;
                    $member->user_id = $user->id;
                    $member->username = $model->username;
                    $member->save();
                    return $this->redirect('@administrator.members');
                }
                $model->addError('username','Ce nom d\'utilisateur est déjà pris');
                return $this->render('new_member',compact('model'));
            }
            return $this->render('new_member',compact('model'));

        }
        return \Yii::$app->end(404);

    }

}