<?php
$user = $member->user();
?>
<?php $this->beginBlock('title') ?>
<?= $user->name." ".$user->first_name ?>
<?php $this->endBlock()?>
<?php $this->beginBlock('style') ?>
<style>
    .img-container {
        display: inline-block;
        width: 150px;
        height: 150px;
    }
    .img-container img{
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
<?php $this->endBlock()?>


<div class="container mt-5 mb-5">
    <div class="row">
        <div class="col-md-4 text-center">
            <div class="img-container">
                <img src="<?= \app\managers\FileManager::loadAvatar($user,"512")?>" alt="">
            </div>
            <h2 class="mt-2 text-capitalize"><?= $member->username?></h2>
        </div>
        <div class="col-md-8 white-block">
            <div class="row labels ">
                <div class="col-5">
                    Nom
                </div>
                <div class="col-7">
                    <?= $user->name ?>
                </div>
                <div class="col-5">
                    Prénom
                </div>
                <div class="col-7">
                    <?= $user->first_name ?>
                </div>
                <div class="col-5">
                    Téléphone
                </div>
                <div class="col-7">
                    <?= $user->tel ?>
                </div>
                <div class="col-5">
                    Email
                </div>
                <div class="col-7">
                    <?= $user->email ?>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-5">
        <div class="col-12 white-block mb-2">
            <div class="row">
                <h5 class="col">
                    <a  class="black-link" href="<?= Yii::getAlias("@administrator.member")."?q=".$member->id ?>">Général</a>
                </h5>
                <h5 class="col">
                    <a class="black-link" href="<?= Yii::getAlias("@administrator.saving_member")."?q=".$member->id ?>">Epargnes</a>
                </h5>
                <h5 class="col">
                    <a class="black-link" href="<?= Yii::getAlias("@administrator.borrowing_member")."?q=".$member->id ?>">Emprunts</a>
                </h5>
                <h5 class="col">
                    <a href="<?= Yii::getAlias("@administrator.contribution_member")."?q=".$member->id ?>">Contributions</a>
                </h5>
            </div>
        </div>
        <div class="col-12">

        </div>
    </div>
</div>