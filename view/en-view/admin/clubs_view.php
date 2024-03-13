<?php
global $clubs;
$GLOBALS['PAGE_TITLE'] = 'Manage Clubs';
addCSS('dashboard.css');
require_view('view/header.php');
?>

<h1><?= $GLOBALS['PAGE_TITLE'] ?></h1>

<!-- Display a table id, name, nb_rooms, opening_hour, closing_hour from club -->
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Number of Rooms</th>
            <th>Opening Hour</th>
            <th>Closing Hour</th>
            <th>Manage</th>
            <th>Delete</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($clubs as $club) : ?>
            <tr>
                <td><?= $club['club_id'] ?></td>
                <td><?= $club['name'] ?></td>
                <td><?= $club['nb_rooms'] ?></td>
                <td><?= $club['opening_hour'] ?></td>
                <td><?= $club['closing_hour'] ?></td>
                <td>
                    <a href="<?= url('/admin/clubs?id=' . $club['club_id']) ?>">Manage</a>
                </td>
                <td>
                    <form action="<?= url('/delete-club') ?>">
                        <input type="hidden" name="club_id" value="<?= $club['club_id'] ?>">
                        <input type="submit" value="Delete" />
                    </form>
                </td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>

<a href="<?= url('/admin/clubs/add') ?>">Add a new club</a>

<?php
require_view('view/footer.php');
?>