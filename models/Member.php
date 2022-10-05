<?php
/**
 * Created by PhpStorm.
 * User: medric
 * Date: 24/12/18
 * Time: 18:04
 */

namespace app\models;


use app\managers\FinanceManager;
use app\managers\SettingManager;
use yii\db\ActiveRecord;

class Member extends ActiveRecord
{

    public function user() {
        return User::findOne($this->user_id);
    }
    public function activeBorrowing() {
        return Borrowing::findOne(['member_id' => $this,'state'=>true]);
    }

    public function savedAmount(Exercise $exercise=null) {
        if ($exercise) {
            $sessions = Session::find()->select('id')->where(['exercise_id' => $exercise->id])->column();
            return Saving::find()->where(['session_id' => $sessions,'member_id' => $this->id])->sum("amount");
        }
        return 0;
    }

    public function exerciseSavings(Exercise $exercise) {
        $sessions = Session::find()->select('id')->where(['exercise_id' => $exercise->id])->column();
        return Saving::find()->where(['session_id' => $sessions,'member_id' => $this->id])->orderBy('created_at',SORT_ASC)->all();
    }

    public function borrowedAmount(Exercise $exercise) {
        $sessions = Session::find()->select('id')->where(['exercise_id' => $exercise->id])->column();
        return Borrowing::find()->where(['session_id' => $sessions,'member_id' => $this->id])->sum("amount");
    }

    public function exerciseBorrowings(Exercise $exercise) {
        $sessions = Session::find()->select('id')->where(['exercise_id' => $exercise->id])->column();
        return Borrowing::find()->where(['session_id' => $sessions,'member_id' => $this->id])->orderBy('created_at',SORT_ASC)->all();
    }

    public function refundedAmount(Exercise $exercise) {
        $sessions = Session::find()->select('id')->where(['exercise_id' => $exercise->id])->column();
        $borrowings = Borrowing::find()->select('id')->where(['member_id' => $this->id,'session_id' => $sessions])->column();
        return Refund::find()->where(['borrowing_id' => $borrowings ])->sum("amount");
    }

    public function interest(Exercise $exercise) {
        $sessions = Session::findAll(['exercise_id' => $exercise->id]);
        $sum = 0;
        foreach($sessions as $session){
            $sum += $this->sessioninterest($session);
        }

        return $sum;
    }

    public function sessioninterest(Session $session) {
        $saving = Saving::find()->where(['<=', 'session_id', $session->id])->sum('amount');
        $memberSaving = Saving::find()->where(['member_id' => $this->id])->andWhere(['<=', 'session_id', $session->id])->sum('amount');
        $borrowings = Borrowing::find()->where(['session_id' => $session->id])->all();
        $borrowings1 = Borrowing::find()->where(['session_id' => $session->id - 1])->all();
        $borrowings2 = Borrowing::find()->where(['session_id' => $session->id - 2 ])->all();
    

        $sum = 0;
        foreach($borrowings as $borrowing){
            $percent = $memberSaving / $saving;
            $sum += $percent*($borrowing->amount*$borrowing->interest);
        }

        $sum1 = 0;
        foreach($borrowings1 as $borrowing1){
            $percent = $memberSaving / $saving;
            $sum1 += $percent*($borrowing1->amount*$borrowing1->interest);
        }

        $sum2 = 0;
        foreach($borrowings2 as $borrowing2){
            $percent = $memberSaving / $saving;
            $sum2 += $percent*($borrowing2->amount*$borrowing2->interest);
        }
        return ($sum + $sum1 + $sum2)/100.0;
    }
   
    public function sessionSumInterest($q) {
        $saving = Saving::find()->where(['<=', 'session_id', $q])->sum('amount');
        $memberSaving = Saving::find()->where(['member_id' => $this->id])->andWhere(['<=', 'session_id', $q])->sum('amount');
        $borrowings = Borrowing::find()->where(['session_id' => $q])->all();
        $borrowings1 = Borrowing::find()->where(['session_id' => $q- 1])->all();
        $borrowings2 = Borrowing::find()->where(['session_id' => $q- 2 ])->all();
    

        $sum = 0;
        foreach($borrowings as $borrowing){
            $percent = $memberSaving / $saving;
            $sum += $percent*($borrowing->amount*$borrowing->interest);
        }

        $sum1 = 0;
        foreach($borrowings1 as $borrowing1){
            $percent = $memberSaving / $saving;
            $sum1 += $percent*($borrowing1->amount*$borrowing1->interest);
        }

        $sum2 = 0;
        foreach($borrowings2 as $borrowing2){
            $percent = $memberSaving / $saving;
            $sum2 += $percent*($borrowing2->amount*$borrowing2->interest);
        }
        return ($sum + $sum1 + $sum2)/100.0;
    }

    public function sessionfonds(Session $session) {
        $memberSaving1 = Saving::find()->where(['member_id' => $this->id])->andWhere(['<=', 'session_id', $session->id])->sum('amount');
        $memberInterest1 = round($this->sessioninterest($session));
        $memberInterest2 = 0;
        for($i=1 ; $i<$session->id ; $i++){
            $memberInterest2 += round($this->sessionSumInterest($i));
        }
        return ($memberSaving1 + ($memberInterest1) + ($memberInterest2)) ;
    }

    public function sessionDettes(Session $session) {
        $borrowings = Borrowing::find()->where(['member_id'=>$this->id])->andWhere(['>=', 'session_id', $session->id])->all();
        $refund = Refund:: find()->where(['member_id'=>$this->id])->andWhere(['<=', 'session_id', $session->id])->sum('amount');
        $interest = SettingManager::getInterest();
        $borrow = Borrowing::find()->where(['member_id'=>$this->id])->andWhere(['<=', 'session_id', $session->id])->sum('amount');
        $indentedAmount = $borrow + 3*($borrow * $interest)/100.0;
        return ($indentedAmount - $refund);
    }

    public function administrator() {
        return Administrator::findOne($this->administrator_id);
    }
}