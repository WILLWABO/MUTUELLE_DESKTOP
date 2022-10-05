<?php $this->beginBlock('title') ?>
Profil
<?php $this->endBlock()?>
<?php $this->beginBlock('style')?>
<style>

</style>
<?php $this->endBlock()?>



<div class="container mt-5 mb-5">
    <div class="row justify-content-center">

        <?php $form1 = \yii\widgets\ActiveForm::begin(['method' => 'post',
            'action' => '@administrator.update_social_information',
            'options' => ['enctype' => 'multipart/form-data','class' => 'col-md-5 mb-2 white-block mr-md-2'],
            'errorCssClass' => 'text-secondary'
        ])?>

        <?= $form1->field($socialModel,'username')->input('text',['required'=>'required'])->label("Nom d'utilisateur") ?>
        <?= $form1->field($socialModel,'first_name')->input('text',['required' => 'required'])->label('Prénom') ?>
        <?= $form1->field($socialModel,'name')->input('text',['required' => 'required'])->label('Nom') ?>
        <?= $form1->field($socialModel,'tel')->input('tel',['required'=>'required'])->label("Téléphone") ?>
        <?= $form1->field($socialModel,'email')->input('email')->label('Email')?>
        <?= $form1->field($socialModel,'address')->input('address')->label('Adresse')?>
        <?= $form1->field($socialModel,'avatar')->fileInput();?>

        <div class="form-group text-right">
            <button type="submit" class="btn btn-primary">Enregistrer</button>
        </div>

        <?php \yii\widgets\ActiveForm::end()?>    
    </div>
</div>