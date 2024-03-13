<?php
global $cgu;
$GLOBALS['PAGE_TITLE'] = 'Conditions Générales d\'Utilisation';
addCSS('CGU.css');
require_view('view/header.php');
?>

<main>
    <h1>Condition Générales D'utilisation</h1>

    <?php
    $i = 0;
    foreach ($cgu as $elem) :
        $i++;
    ?>
        <div>
            <h2><?= $i ?>. <?= $elem['title'] ?></h2>
            <p><?= $elem['content'] ?></p>
        </div>
    <?php endforeach; ?>
</main>

<?php
require_view('view/footer.php');
?>