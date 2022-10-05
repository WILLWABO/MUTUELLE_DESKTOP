<?php $this->beginBlock('title') ?>
Type d'aide
<?php $this->endBlock()?>
<?php $this->beginBlock('style')?>
<?php $this->endBlock()?>

<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-12  white-block">
            <?php $form = \yii\widgets\ActiveForm::begin([
                'method' => 'post',
                'id' => 'form1',
                'action' => '@administrator.apply_help_type_update',
                'errorCssClass' => 'text-secondary',
            ])
            ?>

            <?= $form->field($model,'id')->hiddenInput()->label(false) ?>
            <?= $form->field($model,'title')->label('Titre de l\'aide')->input('text',['required'=>'required']) ?>
            <?= $form->field($model,'amount')->label("Montant")->input('number',['min'=> 0,'required'=>'required'])?>

            <?php \yii\widgets\ActiveForm::end()?>

            <?php $form = \yii\widgets\ActiveForm::begin([
                'method' => 'post',
                'id' => 'form2',
                'action' => '@administrator.delete_help_type',
                'errorCssClass' => 'text-secondary',
            ])
            ?>
            <?= $form->field($model,'id')->hiddenInput()->label(false) ?>

            <?php \yii\widgets\ActiveForm::end()?>

            <div class="text-right">
                <button class="btn btn-secondary" onclick="$('#form2').submit()">Supprimer</button>
                <button class="btn btn-primary" onclick="$('#form1').submit()">Modifier</button>
            </div>

        </div>

    </div>

</div>