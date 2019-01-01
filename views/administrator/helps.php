<?php
/**
 * Created by PhpStorm.
 * User: medric
 * Date: 31/12/18
 * Time: 14:31
 */

use yii\widgets\LinkPager;

$this->beginBlock('title') ?>
Aides
<?php $this->endBlock() ?>
<?php $this->beginBlock('style') ?>
<style>
    .card {
        height: 23rem;
        width: 18rem;
        background-size: 18rem 23rem;
        border-radius: 5px !important;
        overflow: hidden;
        margin-bottom: 10px;

    }
</style>
<?php $this->endBlock() ?>


<div class="container mt-5 mb-5">

    <div class="row mb-5">
        <div class="col-12 white-block">
            <h3 class="text-center text-muted">Aides financiaires actives</h3>
            <hr>

                <?php
                if (count($activeHelps)):
                    ?>
                    <div class="row">
                        <?php
                        foreach ($activeHelps as $help):
                            $user = $help->member()->user();
                            $helpType = $help->helpType();
                            ?>
                            <div class="col-md-4">
                                <!-- Card -->
                                <div class="card card-image" style="background-image: url(<?= \app\managers\FileManager::loadAvatar($user,'512') ?>);">

                                    <!-- Content -->
                                    <div class="text-white text-center justify-content-center align-items-center rgba-black-strong py-3 px-4">
                                        <div>
                                            <h4>Objectif</h4>
                                            <h2><?= $help->amount ?> XAF</h2>
                                            <p ><?= $help->unit_amount ?> XAF / membre</p>
                                            <hr class="bg-white p-0 m-0 my-1">
                                            <h2><?= $help->contributedAmount() ?> XAF</h2>
                                            <p>Contribués</p>
                                            <h5 class="blue-text"><i class="fas fa-user"></i> <?= $user->name." ".$user->first_name ?></h5>
                                            <p class="card-title"><strong><?= $helpType->title ?></strong></p>
                                            <a class="btn btn-primary" href="<?= Yii::getAlias("@administrator.help_details")."?q=".$help->id ?>"><i class="fas fa-clone left"></i> Details</a>
                                        </div>
                                    </div>
                                </div>
                                <!-- Card -->
                            </div>

                        <?php
                        endforeach;
                        ?>
                    </div>
                <?php
                else:?>
                    <h6 class="text-center mt-2">Aucune aide repertoriée</h6>
                <?php
                endif;
                ?>
        </div>
    </div>

    <div class="row">
        <div class="col-12 white-block">
            <h3 class="text-center text-muted">Aides financiaires antérieures</h3>
            <hr>

            <?php
            if (count($helps)):
            ?>
            <div class="row">
                <?php
                foreach ($helps as $help):
                    $user = $help->member()->user();
                $helpType = $help->helpType();
                ?>
                <div class="col-md-4">
                    <!-- Card -->
                    <div class="card card-image" style="background-image: url(<?= \app\managers\FileManager::loadAvatar($user,'512') ?>);">

                        <!-- Content -->
                        <div class="text-white text-center justify-content-center align-items-center rgba-black-strong py-5 px-4">
                            <div>
                                <h3>Objectif</h3>
                                <h1><?= $help->amount ?> XAF</h1>
                                <p  class="mb-5"><?= $help->unit_amount ?> XAF / membre</p>
                                <h5 class="blue-text"><i class="fas fa-user"></i> <?= $user->name." ".$user->first_name ?></h5>
                                <p class="card-title pt-2"><strong><?= $helpType->title ?></strong></p>
                                <a class="btn btn-primary" href="<?= Yii::getAlias("@administrator.help_details")."?q=".$help->id ?>"><i class="fas fa-clone left"></i> Details</a>
                            </div>
                        </div>
                    </div>
                    <!-- Card -->
                </div>

                <?php
                endforeach;
                ?>
                <div class="col-12 mt-3">

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
            </div>
            <?php
            else:?>
            <h6 class="text-center mt-2">Aucune aide repertoriée</h6>
            <?php
            endif;
            ?>
        </div>
    </div>
</div>

<a href="<?= Yii::getAlias("@administrator.new_help") ?>" class="btn btn-primary btn-add"><i class="fas fa-plus"></i></a>