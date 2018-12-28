<?php $this->beginBlock('title') ?>
Modification profil membre
<?php $this->endBlock()?>
<?php $this->beginBlock('style') ?>
<style>
    .error {
        color: red;
    }

    .form-block {
        padding: 20px;
        background-color: white;
        border-radius: 5px;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.49);
    }
</style>
<?php $this->endBlock()?>


<div class="container mt-5 mb-5">
    
    
        <?php $form = \yii\widgets\ActiveForm::begin([
            'method' => 'post',
            'action' => '@administrator.add_member',
            'scrollToError' => true,
            'errorCssClass' =>'error',
            'options' => ['enctype' => 'multipart/form-data','class' => 'col-md-8 col-12 form-block'],
        ]); ?>

        <?= $form->field($model,'username')->label('Nom d\'utilisateur') ?>
        <?= $form->field($model,'first_name')->label('Prénom') ?>
        <?= $form->field($model,'name')->label('Nom') ?>
        <?= $form->field($model,'tel')->input('tel')->label('Téléphone') ?>
        <?= $form->field($model,'email')->input('email')->label('Email') ?>
        <?= $form->field($model,'avatar')->fileInput(['accept' => '.jpg,.jpeg,.png,.gif','required' => 'required'])->label('Photo de profil')?>
        <label>Mot de passe actuel: <input type="text" value="Mot de passe actuel"/></label>
        <?= $form->field($model,'password')->input('password')->label('Mot de passe') ?>

        <div class="form-group text-right">
            <button type="submit" class="btn btn-primary">Enregistrer</button>
        </div>
        <?php \yii\widgets\ActiveForm::end()?>


</div>