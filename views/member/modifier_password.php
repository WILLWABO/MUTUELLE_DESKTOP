<?php $this->beginBlock('title') ?>
Profil
<?php $this->endBlock() ?>
<?php $this->beginBlock('style') ?>
<style>

</style>
<?php $this->endBlock() ?>

<div class="container mt-5 mb-5">
    <div class="row justify-content-center">

        <?php $form2 = \yii\widgets\ActiveForm::begin([
            'method' => 'post',
            'action' =>  '@member.modifiermotdepasse',
            'options' => ['enctype' => 'multipart/form-data','class' => 'col-md-5 mb-2 white-block mr-md-2'],
            'errorCssClass' => 'text-secondary'
        ]) ?>
        <?= $form2->field($passwordModel, 'password')->input('password', ['required' => 'required'])->label('Ancien mot de passe') ?>
        <?= $form2->field($passwordModel, 'new_password')->input('password', ['required' => 'required'])->label('Nouveau mot de passe') ?>
        <?= $form2->field($passwordModel, 'confirmation_new_password')->input('password', ['required' => 'required'])->label('Confirmation du nouveau mot de passe') ?>

        <div class="form-group text-right">
            <button type="submit" class="btn btn-primary">Enregistrer</button>
        </div>
        <?php \yii\widgets\ActiveForm::end() ?>
    </div>
</div>