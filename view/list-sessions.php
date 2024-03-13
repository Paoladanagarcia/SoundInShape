<?php
global $sessions;
global $clubs;
$GLOBALS['PAGE_TITLE'] = 'Liste des sessions';
require_view('view/header.php');
?>

<main>
    <h1>Liste des sessions</h1>

    <!-- print the following in a table:

session_id	
start_hour	
end_hour	
voted_noise_level	
time_noise_level_approved	
club_id -->

    <table>
        <thead>
            <tr>
                <th>Id de la session</th>
                <th>Horaire d'ouverture</th>
                <th>Horaire de fermeture</th>
                <th>Club</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($sessions as $session) : ?>
                <tr>
                    <td><?= $session['session_id'] ?></td>
                    <td><?= $session['start_hour'] ?></td>
                    <td><?= $session['end_hour'] ?></td>
                    <td><?php
                        // Find the name of the club from the club_id
                        foreach ($clubs as $club) {
                            if ($club['club_id'] == $session['club_id']) {
                                echo $club['name'];
                                break;
                            }
                        }
                        ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</main>

<?php
require_view('view/footer.php');
?>