<?php
global $PAGE_TITLE;
global $BOOTSTRAP;
require_once 'utils.php';
?>

<!-- Header -->

<!doctype html>
<html lang="fr">

<head>
    <title><?= $GLOBALS['PAGE_TITLE'] ?></title>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?php if ($GLOBALS['BOOTSTRAP'] !== false) { ?>
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <?php } else { ?>
        <!-- /!\ NO Bootstrap CSS -->
    <?php } ?>

    <!-- Font Awesome CSS -->
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> -->

    <!-- Google Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <!-- JQuery UI CSS -->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

    <!-- JQuery, JQuery UI JS -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>


    <?= addCSSTags() ?>

    <script>
        const DOMAIN_NAME = '<?= getenv('DOMAIN_NAME') ?>';
        // alert(DOMAIN_NAME)
    </script>

    <?php
    if (isset($GLOBALS['NO_AJAX']) && $GLOBALS['NO_AJAX'] == true) { ?>
    <?php } else { ?>
        <script src="<?= url('/view/js/send-forms-ajax.js') ?>"></script>
    <?php } ?>

    <script src="<?= url('/view/js/popup.js') ?>"></script>

</head>

<body>

    <header id="nav-header">
        <div class="header-left">
            <div id="header-logo">
                <img src="<?= url('/view/img/soundinshape-logo.png') ?>" alt="Logo Sound In Shape" width="170" height="170" onclick="window.location.href='<?= url('') ?>'" style="cursor:pointer">
            </div>

            <div>
                <a href="<?= url('') ?>">Accueil</a>
            </div>

            <div>
                <a class="drop-trigger" href="<?= url('/stats/get') ?>">Statistiques ↓</a>
                <!-- display on hover -->
                <div class="drop-content">
                    <a href="<?= url('/sessions') ?>">Sessions</a>
                    <a href="<?= url('/my-sound-profile') ?>">Mon profil sonore</a>
                </div>
            </div>

            <div>
                <a href="<?= url('/forum') ?>">Forum</a>
            </div>

            <div>
                <a href="<?= url('/faq') ?>">FAQ</a>
            </div>

            <div>
                <a class="drop-trigger" href="<?= url('/contact-form') ?>">Contact ↓</a>
                <!-- display on hover -->
                <div class="drop-content">
                    <a href="#qrcode">QR code</a>
                    <a href="#general-info">Info pratique</a>
                </div>
            </div>

            <div>
                <a href="<?= url('/search') ?>">Rechercher</a>
            </div>
        </div>

        <div class="header-right">
            <div>
                <img class="drop-trigger" height=100 width=100 src="<?= url('/view/img/user-icon.png') ?>" alt="Icone Utilisateur" class="nav-img-user" style="cursor:pointer">
                <!-- display on hover -->
                <div class="drop-content">
                    <?php if (is_admin_logged()) : ?>
                        <a href="<?= url('/admin') ?>">Tableau de bord</a>
                    <?php endif ?>
                    <?php if (!is_the_session_started()) : ?>
                        <a href="<?= url('/register') ?>">S'inscrire</a>
                        <a href="<?= url('/login') ?>">Se connecter</a>
                    <?php else : ?>
                        <a href="<?= url('/edit-profile') ?>">Modifier mon profil</a>
                        <a href="<?= url('/logout') ?>">Se déconnecter</a>
                    <?php endif ?>
                </div>

            </div>

            <div>
                <!-- Check lang cookie -->
                <?php
                if ($_COOKIE['lang'] == 'en') {
                ?>
                    <img src="<?= url('/view/img/fr_flag.png') ?>" alt="FR Flag" width="60" height="40" onclick="window.location.href='<?= url('/set-lang-fr') ?>'" style="cursor:pointer" id="lang-flag">
                <?php } else { ?>
                    <img src="<?= url('/view/img/en_flag.webp') ?>" alt="EN Flag" width="60" height="40" onclick="window.location.href='<?= url('/set-lang-en') ?>'" style="cursor:pointer" id="lang-flag">
                <?php } ?>
            </div>
        </div>
    </header>