<?php
global $sessions;
$GLOBALS['PAGE_TITLE'] = 'Manage Sessions';
addCSS('dashboard.css');
require_view('view/header.php');
?>

<h1><?= $GLOBALS['PAGE_TITLE'] ?></h1>

<table>
    <thead>
        <tr>
            <th>Id</th>
            <th>Opening Hour</th>
            <th>Closing Hour</th>
            <!-- <th>Voted Sound Level</th>
            <th>Sound Level Approved (date)</th> -->
            <th>Club ID</th>
            <th>Update</th>
            <th>Delete</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($sessions as $session) : ?>
            <tr>
                <td><?= $session['session_id'] ?></td>
                <td><?= $session['start_hour'] ?></td>
                <td><?= $session['end_hour'] ?></td>
                <!-- <td><?= $session['voted_noise_level'] ?></td>
                <td><?= $session['time_noise_level_approved'] ?></td> -->
                <td><?= $session['club_id'] ?></td>
                <td>
                    <a href="<?= url('/admin/sessions?session_id=' . $session['session_id']) ?>">Update</a>
                </td>
                <td>
                    <form action="<?= url('/delete-session') ?>" method="POST">
                        <input type="hidden" name="session_id" value="<?= $session['session_id'] ?>">
                        <input type="submit" value="Delete">
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<!-- Form to add session -->
<p><a href="<?= url('/admin/session/add') ?>">Add new session</a></p>

<?php
require_view('view/footer.php');
?>