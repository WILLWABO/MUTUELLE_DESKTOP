<?php use yii\widgets\LinkPager;

$this->beginBlock('title') ?>
Categories
<?php $this->endBlock() ?>

<?php $this->beginBlock('style') ?>
<style>
     #btn-add {
        position: fixed!important;
        bottom: 25px;
        right: 25px;
        z-index: 1000;
        border-radius: 100px;
        font-size: 1.3rem;
        width: 50px;
        height: 50px;
        padding: 10px;
    }

    #btn-list {
        position: fixed!important;
        bottom: 25px;
        right: 90px;
        z-index: 1000;
        border-radius: 100px;
        font-size: 1.3rem;
        width: 50px;
        height: 50px;
        padding: 10px;
    }
</style>
<?php $this->endBlock() ?>

<div class="container mt-5 mb-5">
    <div class="row">
        <?php if (count($sessions)) : ?>
            <?php $activeSession = \app\models\Session::findOne(['active' => true]); ?>

            <?php if ($activeSession) : ?>
                <?php $TontineAmount = \app\models\Tontine::find()->where(['session_id' => $activeSession->id])->sum('amount'); ?>
                <?php if ($activeSession->state == "TONTINE") : ?>
                    <a href="<?= Yii::getAlias("@administrator.tontines") ?>" class="btn btn-primary" id="btn-list"><i class="fa fa-book fa-fw"></i></a>
                    <button class="btn <?= $model->hasErrors() ? 'in' : '' ?> btn-primary btn-add" data-toggle="modal" data-target="#modalLRFormDemo"><i class="fas fa-plus"></i></button>
                    <div class="modal fade" id="modalLRFormDemo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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

                                    <?php $form = \yii\widgets\ActiveForm::begin([
                                        'errorCssClass' => 'text-secondary',
                                        'method' => 'post',
                                        'action' => '@administrator.new_categorie',
                                        'options' => ['class' => 'modal-body']
                                    ]) ?>
                                    <?= $form->field($model, 'member_id')->dropDownList($items)->label("Bénéficiaire") ?>

                                    <?= $form->field($model, "amount")->label("Montant de la tontine par membre")->input("number", ['required' => 'required', 'min' => 0]) ?>

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

            <?php foreach ($sessions as $session) : ?>
            <?php $categories = \app\models\Categorie::find()->where(['session_id' => $session->id])->orderBy(['created_at' => SORT_DESC])->all() ?>
            <div class="col-12 white-block mb-2">
                <h5 class="mb-4 text-center">Session du 
                    <span class="text-secondary"><?= (new DateTime($session->date))->format("d-m-Y") ?> <?= $session->active ? '(active)' : '' ?>
                </span>: 
                </h5>
                <?php if (count($categories)) : ?>
                    <table class="table table-hover">
                        <thead class="blue-grey lighten-4">
                            <tr>
                                <th>#</th>
                                <th>Catégorie</th>
                                <th>Bénéficiaire</th>
                                <th>Administrateur</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($categories as $index => $categorie) : ?>
                            <?php $member = \app\models\Member::findOne($categorie->member_id);
                            $memberUser = \app\models\User::findOne($member->user_id);
                            $administrator = \app\models\Administrator::findOne($categorie->administrator_id);
                            $administratorUser = \app\models\User::findOne($administrator->id);
                            ?>
                            <?php
                            if ($session->active && $session->state == "TONTINE") :
                            ?>
                                <tr data-target="#modalS<?= $categorie->id ?>" data-toggle="modal">
                                    <th scope="row"><?= $index + 1 ?></th>
                                    <td class="blue-text"><?= $categorie->amount !=0 ? $categorie->amount : "Libre" ?></td>
                                    <td class="text-capitalize"><?= $memberUser->name . " " . $memberUser->first_name ?></td>
                                    <td class="text-capitalize"><?= $administratorUser->name . " " . $administratorUser->first_name ?></td>
                                </tr>
                                <div class="modal fade" id="modalS<?= $categorie->id ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-body">
                                                <p class="p-1 text-center">
                                                    Êtes-vous sûr(e) de vouloir supprimer cette categorie?
                                                </p>
                                                <div class="text-center">
                                                    <button data-dismiss="modal" class="btn btn-danger">non</button>
                                                    <a href="<?= Yii::getAlias("@administrator.delete_categorie") . "?q=" . $categorie->id ?>" class="btn btn-primary">oui</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php else : ?>
                                <tr>
                                    <th scope="row"><?= $index + 1 ?></th>
                                    <td class="blue-text"><?= $categorie->amount !=0 ? $categorie->amount : "Libre" ?></td>
                                    <td class="text-capitalize"><?= $memberUser->name . " " . $memberUser->first_name ?></td>
                                    <td class="text-capitalize"><?= $administratorUser->name . " " . $administratorUser->first_name ?></td>
                                </tr>
                            <?php
                            endif;
                            ?>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else : ?>
                    <h3 class="text-center text-muted">Aucune catégorie créée</h3>
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