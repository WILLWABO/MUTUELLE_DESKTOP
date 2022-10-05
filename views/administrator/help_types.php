<?php $this->beginBlock('title') ?>
Type d'aide
<?php $this->endBlock()?>
<?php $this->beginBlock('style')?>
<style>
    .table-head {
        background-color: rgba(30, 144, 255, 0.31);
        border-bottom: 1px solid dodgerblue;
    }
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
</style>
<?php $this->endBlock()?>

<div class="container mt-5 mb-5">
    <?php if (count($helpTypes)):?>
        <div class="col-12 white-block mb-2">
            <table class="table table-hover">
                <thead class="blue-grey lighten-4">
                    <tr>
                        <th>#</th>
                        <th>Titre</th>
                        <th>Montant</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($helpTypes as $index => $helpType): ?>
                        <tr>
                            <th scope="row"><?= $index + 1 ?></th>
                            <td><a class="blue-text" href="<?= Yii::getAlias("@administrator.update_help_type")."?q=".$helpType->id?>" class="link"><?= $helpType->title ?></a></td>
                            <td><?= $helpType->amount ?> XAF</td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="row">
            <h1 class="col-12 text-center text-muted">Aucun type d'aide enregistrer</h1>
        </div>
    <?php endif;?>
</div>
<a href="<?= Yii::getAlias("@administrator.new_help_type") ?>" class="btn btn-primary" id="btn-add"><i class="fas fa-plus"></i></a>