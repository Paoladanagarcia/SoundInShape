<?php
global $legal;
$GLOBALS['PAGE_TITLE'] = 'Mentions Légales';
addCSS('legal.css');
require_view('view/header.php');
?>

<main>
    <h1><?= $GLOBALS['PAGE_TITLE'] ?></h1>

    <?php
    $i = 0;
    foreach ($legal as $elem) :
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