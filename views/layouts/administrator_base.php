<?php
use yii\helpers\Html;
$this->title = "Mutuelle - ENSP";
$user = \app\models\User::findOne(Yii::$app->user->getId());
$administrator = \app\models\Administrator::findOne(['user_id' => $user->id]);
?>

<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <?php include Yii::getAlias("@app") . "/includes/links.php"; ?>

        <link href="<?= Yii::getAlias("@web").'/css/admin.css' ?>" rel="stylesheet">

        <title>
            <?php if (isset($this->blocks['title'])): ?>
                <?= $this->blocks['title'] ?>
            <?php else: ?>
                <?= Html::encode($this->title) ?>
            <?php endif; ?>
        </title>



        <style>
            .profile-icon {
                width: 30px;
                height: 30px;
                border-radius: 50px;
            }
            #btn-disconnect {
                margin: 0px;
            }
        </style>

        <?php if (isset($this->blocks['style'])): ?>
            <?= $this->blocks['title'] ?>
        <?php endif; ?>
    </head>
    <body  class="grey lighten-3">
    <?php $this->beginBody() ?>

    <!--Main Navigation-->
    <header>
        <!-- Navbar -->
        <nav class="navbar fixed-top navbar-expand-lg navbar-light white scrolling-navbar">
            <div class="container-fluid">

                <!-- Brand -->
                <a class="navbar-brand waves-effect" href="<?= Yii::getAlias("@administrator.home")?>">
                    <strong class="blue-text d-none d-md-inline">Accueil</strong>
                    <img src="/img/icon.png" alt="ENSP" style="width: 40px; height: 40px;" class="d-md-none">
                </a>

                <!-- Collapse -->
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- Links -->
                <div class="collapse navbar-collapse" id="navbarSupportedContent">

                    <!-- Left -->
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item active">
                            <a class="nav-link waves-effect" href="#">Epargnes</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link waves-effect" href="#">Emprunts</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link waves-effect" href="#">Aides</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link waves-effect" href="#">Sessions</a>
                        </li>
                    </ul>

                    <!-- Right -->
                    <ul class="navbar-nav nav-flex-icons">
                        <li class="nav-item mr-auto">
                            <a href="#" class="nav-link waves-effect">
                                <img src="<?= \app\managers\FileManager::loadAvatar($user)?>" class="profile-icon" alt="<?= $administrator->username ?>">
                                <span><?= $administrator->username ?></span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <form action="<?= Yii::getAlias('@administrator.disconnection')?>" method="post" id="disconnection-form">
                                <input type="hidden" name="<?=Yii::$app->request->csrfParam?>" value="<?=Yii::$app->request->csrfToken?>"/>
                            </form>
                            <button type="button" class="btn btn-white" id="btn-disconnect" onclick="$('#disconnection-form').submit()">Déconnexion</button>
                        </li>
                    </ul>

                </div>

            </div>
        </nav>
        <!-- Navbar -->

        <!-- Sidebar -->
        <div class="sidebar-fixed position-fixed">
            <div class="text-center">
                <a class="logo-wrapper waves-effect" href="<?= Yii::getAlias("@administrator.home") ?>">
                    <img src="<?= Yii::getAlias("@web")."/img/icon.png"?>" class="img-fluid" alt="ENSP">
                </a>
            </div>


            <div class="list-group list-group-flush">
                <a href="#" class="list-group-item active waves-effect">
                    <i class="fas fa-chart-pie mr-3"></i>Tableau de bord
                </a>
                <a href="#" class="list-group-item list-group-item-action waves-effect">
                    <i class="fas fa-user mr-3"></i>Profil</a>
                <a href="#" class="list-group-item list-group-item-action waves-effect">
                    <i class="fas fa-users mr-3"></i>Membres</a>
                <a href="#" class="list-group-item list-group-item-action waves-effect">
                    <i class="fas fa-robot mr-3"></i>Administrateurs</a>
                <a href="#" class="list-group-item list-group-item-action waves-effect">
                    <i class="fas fa-hand-holding-heart mr-3"></i>Type d'aides</a>
            </div>

        </div>
        <!-- Sidebar -->

    </header>
    <!--Main Navigation-->

    <!--Main layout-->
    <main class="pt-5 mx-lg-5">
        <?= $content ?>
    </main>
    <!--Main layout-->

    <!--Footer-->
    <footer class="page-footer text-center font-small primary-color-dark darken-2 mt-4 wow fadeIn">

        <!--Copyright-->
        <div class="footer-copyright py-3">
            © 2018 Copyright: Groupe DEC
        </div>
        <!--/.Copyright-->

    </footer>
    <!--/.Footer-->
    <?php include Yii::getAlias("@app") . "/includes/scripts.php"; ?>

    <!-- Initializations -->
    <script type="text/javascript">
        // Animations initialization
        new WOW().init();

    </script>




    <?php if (isset($this->blocks['script'])): ?>
        <?= $this->blocks['script'] ?>
    <?php endif; ?>

    <?php $this->endBody(); ?>
    </body>

    </html>
<?php $this->endPage(); ?>