<?php
/**
 * Created by PhpStorm.
 * User: medric
 * Date: 29/12/18
 * Time: 20:19
 */

namespace app\managers;


class SettingManager
{
    
    // in order to get the interest from a jason format

    public static function getInterest() {
        $json_source = file_get_contents(\Yii::$app->getBasePath().'/managers/app.json');
        $data = json_decode($json_source,true);
        return $data['interest'];
    }

    // in order to get socialCrown fees

    public static function getSocialCrown() {
        $json_source = file_get_contents(\Yii::$app->getBasePath().'/managers/app.json');
        $data = json_decode($json_source,true);

        return $data['social_crown'];
    }

    // in order to get inscription fees

    public static function getInscription() {
        $json_source = file_get_contents(\Yii::$app->getBasePath().'/managers/app.json');
        $data = json_decode($json_source,true);

        return $data['inscription'];
    }

    public static function setValues($interest,$social_crown,$inscription) {
        $data = [
            'interest'=>$interest,
            'social_crown'=>$social_crown,
            'inscription'=>$inscription,
        ];

        file_put_contents(\Yii::$app->getBasePath().'/managers/app.json',json_encode($data));

    }
}