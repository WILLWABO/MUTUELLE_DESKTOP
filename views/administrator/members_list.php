<?php
$this->beginBlock('title') ?>
Liste des membres
<?php $this->endBlock() ?>
<?php $this->beginBlock('style') ?>
<style>

</style>
<?php $this->endBlock() ?>
<div class="container mt-5 mb-5">
    <div class="row">
        <?php if (count($members)) : ?>
            <div class="col-12 white-block mb-2">
                <h3 class="text-center my-4 blue-text">Liste des membres de la mutuelle</h3>
                <table class="table table-hover">
                    <thead class="blue-grey lighten-4">
                        <tr>
                            <th>#</th>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Téléphone</th>
                            <th>Adresse</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Date inscription</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($members as $index => $member) : ?>
                            <?php $memberUser = \app\models\User::findOne($member->user_id); ?>
                            <tr>
                                <th scope="row"><?= $index + 1 ?></th>
                                <td class="text-capitalize"><a class="blue-text" href="<?= Yii::getAlias("@administrator.member")."?q=".$member->id ?>" class="link"><?= $memberUser->name ?></a></td>
                                <td><?= $memberUser->first_name ?></td>
                                <td class="green-text"><?= $memberUser->tel ?></td>
                                <td><?= $memberUser->address ?></td>
                                <td><?= $memberUser->email ?></td>
                                <td><?= $member->active==1? "actif": "inactif" ?></td>
                                <td><?= (new DateTime($memberUser->created_at))->format("d-m-Y") ?></td>
                            </tr>

                        <?php endforeach; ?>

                    </tbody>
                </table>
            </div>
        <?php else : ?>
            <div class="col-12 white-block">
                <h1 class="text-center text-muted">Aucun membre n'est inscrit pour le moment</h1>
            </div>
        <?php endif; ?>
    </div>
</div>