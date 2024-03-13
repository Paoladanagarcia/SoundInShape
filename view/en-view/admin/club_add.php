<?php
$GLOBALS['PAGE_TITLE'] = 'Manage Club';
addCSS('dashboard.css');
require_view('view/header.php');
?>

<h1><?= $GLOBALS['PAGE_TITLE'] ?></h1>

<!-- Display a table id, name, nb_rooms, opening_hour, closing_hour from club -->
<div class="container">
    <div class="form-container">
        <h1 class="text-center"><?= $GLOBALS['PAGE_TITLE'] ?></h1>

        <form action="<?= url('/admin/clubs/add-post') ?>" method="post">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" value="Nom du club" placeholder="Nom du club" />
            </div>
            <div class="form-group">
                <label for="nb_rooms">Nb of rooms</label>
                <input type="number" name="nb_rooms" id="nb_rooms" value="3" placeholder="3" />
            </div>
            <div class="form-group">
                <label for="opening_hour">Opening Hour</label>
                <input type="time" name="opening_hour" id="opening_hour" value="08:00:00" placeholder="08:30:15" />
            </div>
            <div class="form-group">
                <label for="closing_hour">Closing Hour</label>
                <input type="time" name="closing_hour" id="closing_hour" value="20:00:00" placeholder="20:30:15" />
            </div>

            <div class="form-group">
                <input class="BigButton" type="submit" value="Create Club!" />
            </div>

            <div id="feedback"></div>
        </form>
    </div>
</div>

<?php
require_view('view/footer.php');
?>