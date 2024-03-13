<?php
$GLOBALS['PAGE_TITLE'] = 'Mon profil sonore';
global $suggested_session;
global $user_pref_noise;
addCSS('my-sound-profile.css');
require_view('view/header.php');
?>

<main>

    <div class="text-overlay overlay2">
        <h2>Niveau sonore voulu : </h2>
        <p><button id="decrease">-</button>
            <span id="soundLevel"><?= $user_pref_noise ?></span> dB
            <button id="increase">+</button>
        </p>
    </div>

    <div class="text-overlay overlay3">
        <h2>Suggestion plage horaire :</h2>
        <p id="suggestedTime"><?php echo $suggested_session['start_hour'] . " - " . $suggested_session['end_hour'] ?></p>
    </div>

</main>

<script src="<?= url('/view/js/my-sound-profile.js') ?>"></script>

<?php
require_view('view/footer.php');
?>