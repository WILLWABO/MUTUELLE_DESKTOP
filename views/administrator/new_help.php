<?php
/**
 * Created by PhpStorm.
 * User: medric
 * Date: 23/12/18
 * Time: 20:03
 */
$this->beginBlock('title') ?>
    Nouvelle aide
<?php $this->endBlock() ?>
<?php $this->beginBlock('style') ?>
    <style>
    </style>
<?php $this->endBlock() ?>

<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
            <?php $activeSession = \app\models\Session::findOne(['active' => true]); ?>
            <?php if ($activeSession) : ?>
                <?php if ($activeSession->state == "REFLOATING") : ?>
                    <?php if (count(\app\models\Member::find()->where(['active' => true]) ->all()) >1 ):?>
                        <div class="col-12 mb-2">
                            <h3 class="text-center text-muted">Nouvelle aide financiaire</h3>
                        </div>
                        <?php
                        $form = \yii\widgets\ActiveForm::begin([
                            'method' => 'post',
                            'errorCssClass' => 'text-secondary',
                            'action' => '@administrator.add_help',
                            'options' =>['class' => 'col-md-8 col-12 white-block']
                        ]);

                        $help_types = \app\models\HelpType::find()->where(['active'=> true])->all();
                        $members = \app\models\Member::find()->where(['active' => true])->all();

                        $heps = [];
                        foreach ($help_types as $help_type) {
                            $heps[$help_type->id] = $help_type->title." - ".$help_type->amount.' XAF';
                        }


                        $items = [];
                        foreach ($members as $member) {
                            $user = \app\models\User::findOne($member->user_id);
                            $items[$member->id] = $user->name . " " . $user->first_name;
                        }

                        ?>

                        <?= $form->field($model,"help_type_id")->dropDownList($heps,['required'=> 'required'])->label("Type d'aide") ?>
                        <?= $form->field($model,"member_id")->dropDownList($items, ['required' => 'required'])->label("Membre concern?? par l'aide") ?>
                        <?= $form->field($model,"limit_date")->input("date",['required' => 'required'])->label("Date limite de contribution") ?>
                        <?= $form->field($model,"comments")->textarea(['required' => 'required'])->label("Commentaires ?? propos de l'aide") ?>
                        <?= $form->field($model, 'session_id')->hiddenInput(['value' => $activeSession->id])->label(false) ?>

                    <div class="form-group text-right">
                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                    </div>
                        <?php
                        \yii\widgets\ActiveForm::end();
                        ?>
                    <?php else:?>
                    <div class="col-12">
                        <h3 class="text-center text-muted">Impossible de cr??er une aide avec moins de 2 membres actifs.</h3>
                    </div>
                    <?php endif; ?>
                <?php else: ?>
                <div class="modal-body">
                    <h3 class="text-muted text-center blue-text">Veuillez attendre la phase de renflouement.</h3>
                </div>
                <?php endif; ?>
            <?php else: ?>
                <div class="modal-body">
                    <h3 class="text-muted text-center blue-text">Veuillez cr??er une nouvelle session avant de proc??der ?? la cr??ation de cette aide.</h3>
                </div>
            <?php endif; ?>   
    </div>
</div>

