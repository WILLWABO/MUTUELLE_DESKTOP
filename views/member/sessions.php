<?php

use yii\widgets\LinkPager;
use app\models\Fonds;

$this->beginBlock('title') ?>
 Détails sessions
<?php $this->endBlock() ?>
<?php $this->beginBlock('style') ?>
<style>

</style>
<?php $this->endBlock() ?>
<div class="container mt-5 mb-5">
    <div class="row">
        <?php if (count($exercises)) : ?>

            <div class="col-12 white-block mb-2">
                <h1 class="text-muted text-center">Exercice de l'année <span class="blue-text"><?= $exercises[0]->year ?></span></h1>
                <h3 class="text-secondary text-center"><?= $exercises[0]->active ? "En cours" : "Terminé" ?></h3>
            </div>
            <?php $sessions = \app\models\Session::find()->where(['exercise_id' => $exercises[0]->id])->orderBy(['created_at' => SORT_DESC])->all() ?>
            <?php if (count($sessions)) : ?>
                <?php foreach ($sessions as $index => $session) : ?>
                    <div class="col-12 white-block mb-2">
                        <h3 class="text-center my-4 blue-text">Bilan de la session numéro <span class="text-danger text-center"><?= $session->number() ?>
                            </span> tenue le <?= (new DateTime($session->date))->format("d-m-Y") ?>
                        </h3>
                        <h4 class="mb-4 text-center"> <span class="text-secondary"><?= $session->active ? '(active)' : '' ?></span></h4>
                        <table class="table table-hover">
                            <thead class="blue-grey lighten-4">
                                <tr>
                                    <th>#</th>
                                    <th>Membre</th>
                                    <th>Montant épargné</th>
                                    <th>Montant emprunté</th>
                                    <th>Montant remboursé</th>
                                    <th>Dettes emprunts</th>
                                    <th>Intérêt emprunts</th>
                                    <th>Fonds social</th>
                                    <th>Renflouement</th>
                                    <th>Dettes renflouement</th>
                                    <th>Avoirs</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $members = \app\models\Member::find()->where(['<=','session_id', $session->id])->all() ?>
                                <?php if(count($members)): ?>
                                    <?php foreach ($members as $index => $member) : ?>

                                        <?php $saving = \app\models\Saving::findOne(['member_id'=>$member->id, 'session_id'=>$session->id]);?>
                                        <?php $contributions = \app\models\Contribution::find()->where(['member_id'=>$member->id])->all();?>
                                        <?php $contri = 0 ?>
                                        <?php foreach ($contributions as $contribution) : ?>
                                            <?php $help = \app\models\Help::findOne(['id'=>$contribution->help_id]) ?>
                                            <?php if(($contribution->state == 0  && $help->session_id <= $session->id )|| ($contribution->state ==1 && 
                                                ($help->session_id <= $session->id && $contribution->session_id > $session->id) )) : ?>
                                                <?php $contri += (\app\models\Help::findOne(['id'=>$contribution->help_id]))->unit_amount ?>
                                            <?php endif;?>
                                        <?php endforeach; ?>

                                        <?php $renfloue = 0 ?>
                                        <?php foreach ($contributions as $contribution) : ?>
                                            <?php $help = \app\models\Help::findOne(['id'=>$contribution->help_id]) ?>
                                            <?php if(($contribution->state ==1 && ($contribution->session_id == $session->id))) : ?>
                                                <?php $renfloue += (\app\models\Help::findOne(['id'=>$contribution->help_id]))->unit_amount ?>
                                            <?php endif;?>
                                        <?php endforeach; ?>

                                        <?php $i = \app\managers\SettingManager::getInterest()?>

                                        <?php $borrowing = \app\models\Borrowing::findOne(['member_id'=>$member->id, 'session_id'=>$session->id]);?>
                                        
                                        <?php $social = \app\models\Social::find()->where(['member_id'=>$member->id])->andWhere(['<=', 'session_id', $session->id])->sum('amount');?>
                                        
                                        <?php $borrowings = \app\models\Borrowing::findOne(['member_id'=>$member->id]);?>
                                        
                                        <?php $refunds = is_object($borrowings) ? \app\models\Refund::findOne(['session_id'=>$session->id, 'borrowing_id'=>$borrowings->id]) : 0?>
                                         
                                        <?php $memberUser = \app\models\User::findOne($member->user_id);?>

                                        <?php $interest = $member->sessioninterest($session);?>
                                        <tr>
                                            <th scope="row"><?= $index + 1 ?></th>
                                            <td class="text-capitalize"><?= $memberUser->name ?></td>
                                            <td class="green-text"><?= $saving ? $saving->amount : " " ?></td>
                                            <td class="green-text"><?= $borrowing ? $borrowing->amount : " " ?></td>
                                            <td><?= is_object($refunds)  ? $refunds->amount : " " ?></td>
                                            <td class="red-text"> <?= $member->sessionDettes($session) !=0 ? $member->sessionDettes($session) : " " ?> </td>
                                            <td class="green-text"><?= round($interest) !=0 ? round($interest) : " "  ?></td>
                                            <td>
                                                <?php $s = \app\managers\SettingManager::getSocialCrown()?>
                                                <?php if ($social == $s && $social):?>
                                                    <span class="blue-text"> <?= $social ?> </span>
                                                <?php else:?>
                                                    <span class="red-text"><?= $social ? : 0 ?></span>
                                                <?php endif;?>
                                            </td>
                                            <td class="red-text"><?= $renfloue !=0 ? $renfloue: " " ?></td>
                                            <td class="red-text"><?= $contri !=0 ? $contri : " " ?></td>
                                            <td class="text-capitalize green-text"><?= $member->sessionfonds($session)?></td>
                                        </tr>
                                        
                                    <?php endforeach; ?>
                                    <?php else:?>
                                        <h3 class="text-center text-muted">Aucun membre inscrit</h3>
                                    <?php endif; ?>

                                </tbody>
                        </table>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <div class="col-12 white-block mb-2">
                    <h1 class="text-center text-muted">Aucune session créée pour cet exercice.</h1>
                </div>
            <?php endif; ?>

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
                <h1 class="text-center text-muted">Aucun exercice créé.</h1>
            </div>

        <?php endif; ?>

    </div>
</div>