<?php
global $sensor_id;
global $stats;
$GLOBALS['PAGE_TITLE'] = 'Monitor sensor ' . $sensor_id;
addCSS('dashboard.css');
require_view('view/header.php');
?>

<h1><?= $GLOBALS['PAGE_TITLE'] ?></h1>

<table>
    <thead>
        <tr>
            <th>noise_recording_id</th>
            <th>timepoint</th>
            <th>noise_level</th>
            <th>statistic_id</th>
            <th>sensor_id</th>
            <th>session_id</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($stats as $stat) : ?>
            <tr>
                <td><?= $stat['noise_recording_id'] ?></td>
                <td>
                    <form action="<?= url('/update-stats-timepoint') ?>" method="post">
                        <input type="hidden" name="noise_recording_id" value="<?= $stat['noise_recording_id'] ?>">
                        <input type="datetime-local" name="timepoint" value="<?= $stat['timepoint'] ?>">
                        <input type="submit" value="Sauvegarder" class="BigButton">
                    </form>
                </td>
                <td>
                    <form action="<?= url('/update-stats-level') ?>" method="post">
                        <input type="hidden" name="noise_recording_id" value="<?= $stat['noise_recording_id'] ?>">
                        <input type="number" name="noise_level" value="<?= $stat['noise_level'] ?>">
                        <input type="submit" value="Sauvegarder" class="BigButton">
                    </form>
                </td>
                <td><?= $stat['statistic_id'] ?></td>
                <td><?= $stat['sensor_id'] ?></td>
                <td><?= $stat['session_id'] ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php
require_view('view/footer.php');
?>