<?php

use yii\widgets\LinkPager;

$user = $member->user();
?>
<?php $this->beginBlock('title') ?>
<?= $user->name . " " . $user->first_name ?>
<?php $this->endBlock() ?>
<?php $this->beginBlock('style') ?>
<style>
    .img-container {
        display: inline-block;
        width: 150px;
        height: 150px;
    }

    .img-container img {
        width: 100%;
        height: 100%;
        border-radius: 1000px;
    }

    .white-block {
        padding: 20px;
        background-color: white;
        border-radius: 5px;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.49);
    }

    .labels .col-7 {
        color: dodgerblue;
    }
</style>
<?php $this->endBlock() ?>

<div class="container mt-5 mb-5">
    <div class="row mt-5">
        <div class="col-12 white-block">
            <?php if (count($exercises)): ?>
                <?php
                $exercise = $exercises[0];
                $tontines = \app\models\Tontine::findAll(['member_id' => $member->id]);
                ?>
                <h3 class="my-3 text-center">Exercice de <span class="text-secondary"><?= $exercise->year ?></span></h3>
                <?php if (count($tontines)):?>

                    <table class="table table-hover">
                        <thead class="blue-grey lighten-4">
                        <tr>
                            <th>#</th>
                            <th>Montant</th>
                            <th>Bénéficiaire</th>
                            <th>Administrateur</th>
                            <th>Session</th>
                        </tr>

                        </thead>
                        <tbody>
                        <?php foreach ($tontines as $index => $tontine): ?>
                            <?php
                            $categorie = \app\models\Categorie::findOne(['id' => $tontine->categorie_id]);
                            $memberB = \app\models\Member::findOne(['id' => $categorie->member_id]);
                            $userB = $memberB->user();
                            $amount = $tontine->amount;
                            $administrator = $tontine->administrator()->user();
                            $session = $tontine->session();
                            ?>
                            <tr>
                                <th scope="row"><?= $index + 1 ?></th>
                                <td class="blue-text"><?= $amount ? $amount : 0 ?> XAF</td>
                                <td><?= $userB->name." ". $userB->first_name?></td>
                                <td class="text-capitalize"><?= $administrator->name." ". $administrator->first_name ?></td>
                                <td><?= $session->date() ?></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else:?>
                <h3 class="text-center text-muted">Aucune tontine ne conerne ce membre</h3>
                <?php endif; ?>



                <div class="mt-2 p-2">
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

            <?php else: ?>
                <h3 class="text-center text-muted">Aucun exercice enregistré.</h3>
            <?php endif; ?>
        </div>
    </div>
</div>
