<?php
global $sensors;
global $sessions;
$GLOBALS['PAGE_TITLE'] = "Consulter les statistiques";
addCSS('show-stats.css');
require_view('view/header.php');
?>

<div class="container-sm mx-auto">
    <h1><?= $GLOBALS['PAGE_TITLE'] ?></h1>

    <button type="button" id="btn-new-stats-dialog" class="btn btn-info">Afficher une nouvelle fenêtre de statistiques</button>

    <!-- BELOW DIALOG IS NOT SHOWN. IT IS DUPLICATED IN JAVASCRIPT WHEN OPENING OTHER DIALOGS -->
    <!-- it doesnt have a id="canvas-container-id" -->
    <div id="sample-dialog" style="display: none;" class="canvas-dialog" title="Panneau de statistiques">
        <form name="form-select-stats">
            <fieldset class="p-2" style="border: 1px solid orange;">
                <legend>Choisir une donnée à visualiser</legend>

                <!-- radio button if user want to see the noise level or the number of people -->
                <div class="row">
                    <div class="col-12">Visualiser le niveau sonore ou le nombre de personnes ?</div>
                    <div class="col-12">
                        <div class="form-check">
                            <input type="radio" name="stats_type" class="stats_type form-check-input" value="noise" id="noise" checked="checked">
                            <label class="form-check-label" for="noise">Niveau sonore</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" name="stats_type" class="stats_type form-check-input" value="people" id="people">
                            <label class="form-check-label" for="people">Nombre de personnes</label>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col container-select-sensor">
                        <div class="form-group mb-2">
                            <label for="sensor_id">Capteur</label>
                            <select name="sensor_id" id="sensor_id" class="sensor_id form-control">
                                <option value="">-- N'importe quel capteur --</option>
                                <?php foreach ($sensors as $sensor) : ?>
                                    <option value="<?= $sensor['sensor_id'] ?>"><?= $sensor['sensor_id'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="col">
                        <div class="form-group mb-2">
                            <label for="session_id">Session</label>
                            <select name="session_id" id="session_id" class="session_id form-control">
                                <option value="">-- N'importe quelle session --</option>
                                <?php foreach ($sessions as $session) : ?>
                                    <option value="<?= $session['session_id'] ?>"><?= $session['start_hour'] . ' - ' . $session['end_hour'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="col">
                        <div class="form-group mb-2">
                            <label for="date">Max. Points</label>
                            <input type="number" name="max_points" class="max_points form-control" placeholder="Nombre de points maximal" value=100>
                        </div>
                    </div>
                </div>
            </fieldset>
        </form>
        <canvas class="show-stats-canvas"></canvas>
        <p class="form-select-stats-feedback"></p>
    </div>
</div>

<script src="<?= url('/view/js/chart.js') ?>"></script>
<script src="<?= url('/view/js/show-stats.js') ?>"></script>
<script>

</script>