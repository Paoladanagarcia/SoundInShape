<?php
global $sensors;
$GLOBALS['PAGE_TITLE'] = 'Gérer les capteurs';
addCSS('dashboard.css');
require_view('view/header.php');
?>

<h1><?= $GLOBALS['PAGE_TITLE'] ?></h1>

<ul>
    <?php foreach ($sensors as $sensor) : ?>
        <li>
            <a href="<?= url('/admin/sensors?sensor_id=' . $sensor['sensor_id']) ?>">
                Capteur #<?= $sensor['sensor_id'] ?>
            </a>
        </li>
    <?php endforeach; ?>
</ul>

<?php
require_view('view/footer.php');
?>