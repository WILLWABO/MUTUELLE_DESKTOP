<?php

use yii\widgets\LinkPager;

$this->beginBlock('title') ?>
Tontines
<?php $this->endBlock() ?>
<?php $this->beginBlock('style') ?>
<style>
</style>
<?php $this->endBlock() ?>


<div class="container mt-5 mb-5">
    <div class="row">
        <?php if (count($sessions)) : ?>
            <?php $activeSession = \app\models\Session::findOne(['active' => true]); ?>
            <?php if ($activeSession) : ?>
                <?php $categorie = \app\models\Categorie::find()->where(['session_id' => $activeSession->id])->max('id'); ?>
                <?php if ($activeSession->state == "TONTINE") : ?>
                    <button class="btn <?= $model->hasErrors() ? 'in' : '' ?> btn-primary btn-add" data-toggle="modal" data-target="#modalLRFormDemoo"><i class="fas fa-plus"></i></button>
                    <div class="modal fade" id="modalLRFormDemoo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <?php $members = \app\models\Member::find()->where(['active' => true])->all() ?>
                                <?php if (count($members)) : ?>
                                    <?php
                                    $items = [];
                                    foreach ($members as $member) {
                                        $user = \app\models\User::findOne($member->user_id);
                                        $items[$member->id] = $user->name . " " . $user->first_name;
                                    }
                                    ?>
                                    <?php $categories = \app\models\Categorie::find()->where(['session_id' => $activeSession->id])->andWhere(['id'=>intval($categorie)])->all(); ?>
                                    <?php
                                    $cat = [];
                                    $montant=0;
                                    foreach ($categories as $tab) {
                                        $cat[$tab->amount] = $tab->amount;
                                        $montant = $tab->amount;
                                    }
                                    ?>
                                    <?php $form = \yii\widgets\ActiveForm::begin([
                                        'errorCssClass' => 'text-secondary',
                                        'method' => 'post',
                                        'action' => '@administrator.new_tontine',
                                        'options' => ['class' => 'modal-body']
                                        ])
                                    ?>
                                    <?= $form->field($model, 'member_id')->dropDownList($items)->label("Membre") ?>
                                    <?php if($montant!=0):?>
                                        <?= $form->field($model, "amount")->dropDownList($cat)->label("Montant") ?>
                                    <?php else: ?>
                                        <?= $form->field($model, "amount")->label("Montant")->input("number", ['required' => 'required', 'min' => 0]) ?>
                                    <?php endif; ?>
                                    <?= $form->field($model, 'session_id')->hiddenInput(['value' => $activeSession->id])->label(false) ?>
                                    <?= $form->field($model, 'categorie_id')->hiddenInput(['value' => intval($categorie)])->label(false) ?>
                                    <div class="form-group text-right">
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Annuler</button>
                                        <button type="submit" class="btn btn-primary">Ajouter</button>
                                    </div>
                                    <?php \yii\widgets\ActiveForm::end(); ?>
                                </div>
                                <?php else : ?>
                                    <div class="modal-body">
                                        <h3 class="text-muted text-center">Aucun membre inscrit</h3>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            <?php else : ?>
                <div class="col-12 white-block mb-5">
                    <h3 class="text-muted text-center">Aucune session active</h3>
                </div>
        <?php endif; ?>
        <?php foreach ($sessions as $session) : ?>
            
            <?php $categories = \app\models\Categorie::find()->where(['session_id' => $session->id])->orderBy(['created_at' => SORT_DESC])->all() ?>
            <div class="col-12  mb-2">
            <div class="col-12 white-block mb-1 text-center">
                <h5 class="mb-4">Session du 
                    <span class="text-secondary"><?= (new DateTime($session->date))->format("d-m-Y") ?> <?= $session->active ? '(active)' : '' ?></span>: 
                </h5>
            </div>
            <?php if (count($categories)) : ?>
                <?php foreach ($categories as $categorie) : ?>
                    <?php $member = \app\models\Member::findOne($categorie->member_id);
                    $totalCategorie = \app\models\Tontine::find()->where(['session_id' => $session->id, 'categorie_id' => $categorie->id])->sum('amount');
                    $User = \app\models\User::findOne($member->user_id);
                    ?>
                    
                    <?php $tontines = \app\models\Tontine::findAll(['session_id' => $session->id, 'categorie_id' => $categorie->id]) ?>
                    <div class="col-12 white-block mb-2">
                        
                            <h5 class="text-muted text-center blue-text"> Catégorie: <?= $categorie->amount !=0 ? $categorie->amount :"Libre" ?> _____
                             Bénéficiaire: <?= $User->name . " " . $User->first_name ?> 
                             (<?= $totalCategorie ? $totalCategorie : 0 ?> XAF) 
                            </h5>
            
                        
                        <?php if (count($tontines)) : ?>
                            <table class="table table-hover">
                                <thead class="blue-grey lighten-4">
                                    <tr>
                                        <th>#</th>
                                        <th>Membre</th>
                                        <th>Montant</th>
                                        <th>Administrateur</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($tontines as $index => $tontine) : ?>
                                    <?php $member = \app\models\Member::findOne($tontine->member_id);
                                    $memberUser = \app\models\User::findOne($member->user_id);
                                    $administrator = \app\models\Administrator::findOne($tontine->administrator_id);
                                    $administratorUser = \app\models\User::findOne($administrator->id);
                                    ?>
                                    <?php
                                    if ($session->active && $session->state == "TONTINE") :
                                    ?>
                                        <tr data-target="#modalS<?= $tontine->id ?>" data-toggle="modal">
                                            <th scope="row"><?= $index + 1 ?></th>
                                            <td class="text-capitalize"><?= $memberUser->name . " " . $memberUser->first_name ?></td>
                                            <td class="blue-text"><?= $tontine->amount ?> XAF</td>
                                            <td class="text-capitalize"><?= $administratorUser->name . " " . $administratorUser->first_name ?></td>
                                        </tr>
                                        <div class="modal fade" id="modalS<?= $tontine->id ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-body">
                                                        <p class="p-1 text-center">
                                                            Êtes-vous sûr(e) de vouloir supprimer cette tontine?
                                                        </p>
                                                        <div class="text-center">
                                                            <button data-dismiss="modal" class="btn btn-danger">non</button>
                                                            <a href="<?= Yii::getAlias("@administrator.delete_tontine") . "?q=" . $tontine->id ?>" class="btn btn-primary">oui</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php else : ?>
                                        <tr>
                                            <th scope="row"><?= $index + 1 ?></th>
                                            <td class="text-capitalize"><?= $memberUser->name . " " . $memberUser->first_name ?></td>
                                            <td class="blue-text"><?= $tontine->amount ?> XAF</td>
                                            <td class="text-capitalize"><?= $administratorUser->name . " " . $administratorUser->first_name ?></td>
                                        </tr>
                                    <?php
                                    endif;
                                    ?>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php else : ?>
                            <h3 class="text-center text-muted">Aucune tontine pour cette catégorie</h3>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>    
            <?php else : ?>
                <h3 class="text-center text-muted">Aucune tontine créée</h3>
            <?php endif; ?>
            </div>    
        <?php endforeach; ?>
        <div class="col-12 p-2">
            <nav aria-label="Page navigation example">
                <?= LinkPager::widget([
                    'pagination' => $pagination,
                    'options' => [
                        'class' => 'pagination pagination-circle justify-content-center pg-blue mb-0',
                    ],
                    'pageCssClass' => 'page-item',
                    'disabledPageCssClass' => 'd-none',
                    'prevPageCssClass' => 'page-item',
                    'nextPageCssClass' => 'page-item',
                    'firstPageCssClass' => 'page-item',
                    'lastPageCssClass' => 'page-item',
                    'linkOptions' => ['class' => 'page-link']
                    ]) ?>
            </nav>
        </div>
        <?php else : ?>
            <div class="col-12 white-block">
                <h1 class="text-muted text-center">Aucune session créée</h1>
            </div>
        <?php endif; ?>
    </div>
</div>