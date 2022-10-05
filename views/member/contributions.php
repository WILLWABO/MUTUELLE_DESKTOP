<?php
use yii\helpers\Html;
use app\models\Administrator;
use app\models\Exercise;
use app\models\Help;
use app\models\Help_type;
use app\models\Member;
use app\models\Session;
?>
<?php $this->beginBlock('title') ?>
Mes contributions
<?php $this->endBlock()?>
<?php $this->beginBlock('style')?>
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

    <?php if (count($contributions)):?>
    
        <div class="col-12 white-block mb-2">
            <table class="table table-hover">
                <thead class="blue-grey lighten-4">
                    <tr>
                        <th>#</th>
                        <th>Montant</th>
                        <th>Date</th>
                        <th>Administrateur</th>
                        <th>Membre aidé</th>
                        <th>Motif</th>
                        <th>Réglée</th>
                    </tr>
                </thead>
            
                <tbody>
                    <?php foreach ($contributions as $index => $contribution): 
                    // $admin = Administrator::findOne(['id'=> $contribution->administrator_id]);
                    $help = Help::findOne(['id'=> $contribution->help_id]);
                    $helptype = Help_type::findOne(['id'=> $help->help_type_id]);
                    $member = Member::findOne(['id'=> $help->member_id]);
                    $administrator = $contribution->administrator();
                    $administratorUser = $administrator?$administrator->user():null;
                    //$session = Session::findOne(['id'=> $borrowing->session_id]);
                    //$exercise = Exercise::findOne(['id'=> $session->exercise_id]); ?>

                        <tr>
                            <th scope="row" ><?= $index + 1 ?></th>
                            <td ><?= $help->unit_amount ?> XAF</td>
                            <td><?= (new DateTime($contribution->date))->format("d-m-Y") ?></td>
                            <td class="text-capitalize"><?=$administratorUser?$administratorUser->name . " " . $administratorUser->first_name: "###" ?></td>
                            <td class="text-secondary"><?= $member->username ?></td>
                            <td class="text-secondary"><?= $helptype->title ?></td>
                            <td class="text-capitalize"><?=$administratorUser?"Oui": "Non" ?></td>
                                    
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else:?>
        <h3 class="text-center text-muted">Vous n'avez fait aucune contribution.</h3>
    <?php endif; ?>
</div>