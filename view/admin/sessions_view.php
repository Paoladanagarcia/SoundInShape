<?php
global $sessions;
$GLOBALS['PAGE_TITLE'] = 'Gérer les sessions';
addCSS('dashboard.css');
require_view('view/header.php');
?>

<h1><?= $GLOBALS['PAGE_TITLE'] ?></h1>

<!-- Display in a table:
session_id	
start_hour	
end_hour	
voted_noise_level	
time_noise_level_approved	
club_id
-->
<table>
    <thead>
        <tr>
            <th>Id</th>
            <th>Heure de début</th>
            <th>Heure de fin</th>
            <!-- <th>Niveau de bruit voté</th>
            <th>Niveau de bruit approuvé (date)</th> -->
            <th>Club ID</th>
            <th>Modifier</th>
            <th>Supprimer</th>
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
                    <a href="<?= url('/admin/sessions?session_id=' . $session['session_id']) ?>">Modifier</a>
                </td>
                <td>
                    <form action="<?= url('/delete-session') ?>" method="POST">
                        <input type="hidden" name="session_id" value="<?= $session['session_id'] ?>">
                        <input type="submit" value="Supprimer">
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<!-- Form to add session -->
<p><a href="<?= url('/admin/session/add') ?>">Ajouter une session</a></p>

<?php
require_view('view/footer.php');
?>