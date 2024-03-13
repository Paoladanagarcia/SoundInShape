<?php
global $sessions;
global $clubs;
$GLOBALS['PAGE_TITLE'] = 'List of Sessions';
require_view('view/header.php');
?>

<main>
    <h1>List of Sessions</h1>

    <table>
        <thead>
            <tr>
                <th>Session ID</th>
                <th>Opening Time</th>
                <th>Closing Time</th>
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