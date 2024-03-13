<?php
$GLOBALS['PAGE_TITLE'] = 'Ajouter une session';
addCSS('dashboard.css');
require_view('view/header.php');
?>

<!-- Display a table 
start_hour	
end_hour	
voted_noise_level	
time_noise_level_approved	
club_id-->
<div class="container">
    <div class="form-container">
        <h1 class="text-center"><?= $GLOBALS['PAGE_TITLE'] ?></h1>

        <form action="<?= url('/post-add-session') ?>" method="post">
            <div class="form-group">
                <label for="start_hour">Heure d'ouverture</label>
                <input type="time" name="start_hour" id="start_hour" value="09:00:00" placeholder="Heure d'ouverture" />
            </div>
            <div class="form-group">
                <label for="end_hour">Heure de fermeture</label>
                <input type="time" name="end_hour" id="end_hour" value="18:00:00" placeholder="Heure de fermeture" />
            </div>
            <!-- <div class="form-group">
                <label for="voted_noise_level">Niveau sonore voté</label>
                <input type="number" name="voted_noise_level" id="voted_noise_level" value="" placeholder="Laisser vide" readonly />
            </div>
            <div class="form-group">
                <label for="time_noise_level_approved">Niveau sonore approuvé (jour, heure)</label>
                <input type="datetime-local" name="time_noise_level_approved" id="time_noise_level_approved" value="" placeholder="Laisser vide" readonly />
            </div> -->
            <div class="form-group">
                <label for="club_id">Id du club</label>
                <input type="number" name="club_id" id="club_id" value="1" placeholder="1" readonly />
            </div>

            <div class="form-group">
                <input class="BigButton" type="submit" value="Créer cette session" />
            </div>

            <div id="feedback"></div>
        </form>
    </div>
</div>

<?php
require_view('view/footer.php');
?>