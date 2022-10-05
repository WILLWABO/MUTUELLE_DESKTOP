<?php  use yii\widgets\LinkPager;

$this->beginBlock('title') ?>
Social
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
                <?php $total = \app\models\Social::find()->where(['session_id' => $activeSession->id])->sum('amount'); ?>
                <div class="col-12 white-block text-center mb-5">
                    <h3>Session active</h3>
                    <h3 class="blue-text"> Fonds en caisse : <?= $total ? $total : 0 ?> XAF</h3>
                </div>
                <?php if ($activeSession->state == "SOCIALCROWN") : ?>
                    <button class="btn <?= $model->hasErrors() ? 'in' : '' ?> btn-primary btn-add" data-toggle="modal" data-target="#modalLRFormDemo"><i class="fas fa-plus"></i></button>
                    <div class="modal fade" id="modalLRFormDemo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <?php $members = \app\models\Member::find()->where(['active' => true])->andWhere(['<','social_crown', \app\managers\SettingManager::getSocialCrown()])->all() ?>


                                <?php if (count($members)) : ?>

                                    <?php
                                    $items = [];
                                    foreach ($members as $member) {
                                        $user = \app\models\User::findOne($member->user_id);
                                        $items[$member->id] = $user->name . " " . $user->first_name;
                                    }
                                    ?>

                                    <?php $form = \yii\widgets\ActiveForm::begin([
                                        'errorCssClass' => 'text-secondary',
                                        'method' => 'post',
                                        'action' => '@administrator.new_social',
                                        'options' => ['class' => 'modal-body']
                                    ]) ?>
                                    <?= $form->field($model, 'member_id')->dropDownList($items)->label("Membre") ?>

                                    <?= $form->field($model, "amount")->label("Montant")->input("number", ['required' => 'required', 'min' => 0]) ?>

                                    <?= $form->field($model, 'session_id')->hiddenInput(['value' => $activeSession->id])->label(false) ?>
                                    <div class="form-group text-right">
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Annuler
                                        </button>
                                        <button type="submit" class="btn btn-primary">Ajouter</button>
                                    </div>
                                    <?php \yii\widgets\ActiveForm::end(); ?>


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

            <?php foreach ($sessions as $session): ?>
                <?php $sociaux = \app\models\Social::findAll(['session_id' => $session->id]) ?>
                <div class="col-12 white-block mb-2">
                    <?php $total = \app\models\Social::find()->where(['session_id' => $session->id])->sum('amount'); ?>
                    <h3 class="text-center my-4 blue-text">Fonds social à la session numéro <span class="text-danger text-center"><?= $session->number() ?></span> tenue le <?= (new DateTime($session->date))->format("d-m-Y") ?></h3>
                    <h5 class="text-center mb-4"><span class="text-secondary"> Total perçu: <span class="blue-text"><?= $total ? $total : 0 ?> XAF</span></h5>

                    <?php if (count($sociaux)): ?>
                        <table class="table table-hover">
                            <thead class="blue-grey lighten-4">
                            <tr>
                                <th>#</th>
                                <th>Membre</th>
                                <th>Fonds social</th>
                                <th>Reste</th>
                                <th>Administrateur</th>
                            </tr>

                            </thead>
                            <tbody>
                            <?php foreach ($sociaux as $index => $social): ?>
                                <?php $member = \app\models\Member::findOne($social->member_id);
                                $totalsocial = \app\models\Social::find()->where(['member_id'=>$member->id])->andWhere(['<=', 'session_id', $session->id])->sum('amount');
                                $s = \app\managers\SettingManager::getSocialCrown();
                                $memberUser = \app\models\User::findOne($member->user_id);
                                $administrator = \app\models\Administrator::findOne($social->administrator_id);
                                $administratorUser = \app\models\User::findOne($administrator->id);
                                ?>
                                <?php if ($session->active && $session->state == "SOCIALCROWN"):?>
                                    <tr data-target="#modalS<?= $social->id?>" data-toggle="modal">
                                        <th scope="row"><?= $index + 1 ?></th>
                                        <td class="text-capitalize"><?= $memberUser->name . " " . $memberUser->first_name ?></td>
                                        <td class="blue-text"><?= $totalsocial ?> XAF</td>
                                        <td> 
                                            <?php
                                             if($s - $totalsocial> 0):
                                             ?>
                                            <span class="red-text"><?= $s - $totalsocial ?> XAF </span>
                                            <?php
                                            else:
                                            ?>
                                            <span class="green-text">réglé</span> 
                                            <?php
                                            endif
                                            ;?> 
                                        </td>
                                        <td class="text-capitalize"><?= $administratorUser->name . " " . $administratorUser->first_name ?></td>
                                    </tr>
                                    <div class="modal fade" id="modalS<?= $social->id ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-body">
                                                    <p class="p-1 text-center">
                                                        Êtes-vous sûr(e) de vouloir supprimer ce versement?
                                                    </p>
                                                    <div class="text-center">
                                                        <button data-dismiss="modal" class="btn btn-danger">non</button>
                                                        <a href="<?= Yii::getAlias("@administrator.delete_social")."?q=".$social->id?>" class="btn btn-primary">oui</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <tr>
                                        <th scope="row"><?= $index + 1 ?></th>
                                        <td class="text-capitalize"><?= $memberUser->name . " " . $memberUser->first_name ?></td>
                                        <td class="blue-text"><?= $totalsocial ?> XAF</td>
                                        <td> 
                                            <?php
                                             if($s - $totalsocial):
                                             ?>
                                            <span class="red-text"><?= $s - $totalsocial ?> XAF </span>
                                            <?php
                                            else:
                                            ?>
                                            <span class="green-text">réglé</span> 
                                            <?php
                                            endif
                                            ;?> 
                                        </td>
                                        <td class="text-capitalize"><?= $administratorUser->name . " " . $administratorUser->first_name ?></td>
                                    </tr>
                                <?php endif; ?>
                            <?php endforeach; ?>
                            </tbody>
                        </table>

                    <?php else: ?>
                        <h3 class="text-center text-muted">Aucun fonds enregistré à cette session</h3>
                    <?php endif; ?>


                </div>
            <?php endforeach; ?>
            <div class="col-12 p-2">
                <nav aria-label="Page navigation example">
                    <?= LinkPager::widget(['pagination' => $pagination,
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