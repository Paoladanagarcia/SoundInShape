<?php
global $session;
$GLOBALS['PAGE_TITLE'] = 'Manage Session';
addCSS('dashboard.css');
require_view('view/header.php');
?>

<main class="container">
    <h1><?= $GLOBALS['PAGE_TITLE'] ?></h1>

    <form action="<?= url('/post-manage-session') ?>" method="post">
        <input type="hidden" name="session_id" value="<?= $session['session_id'] ?>">
        <label for="start_hour">Opening Hour</label>
        <input type="time" name="start_hour" id="start_hour" value="<?= $session['start_hour'] ?>">

        <label for="end_hour">Closing Hour</label>
        <input type="time" name="end_hour" id="end_hour" value="<?= $session['end_hour'] ?>">

        <label for="voted_noise_level">Voted Sound Level</label>
        <input type="text" name="voted_noise_level" id="voted_noise_level" value="<?= $session['voted_noise_level'] ?>">

        <label for="time_noise_level_approved">Time Sound Level Approved</label>
        <input type="datetime-local" name="time_noise_level_approved" id="time_noise_level_approved" value="<?= $session['time_noise_level_approved'] ?>">

        <label for="club_id">Club ID</label>
        <input type="number" name="club_id" id="club_id" value="<?= $session['club_id'] ?>">

        <input type="submit" value="Modifier" class="BigButton">

        <div id="feedback"></div>
    </form>
</main>

<!-- Form to add session -->

<?php
require_view('view/footer.php');
?>