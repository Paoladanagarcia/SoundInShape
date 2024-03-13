<?php

class StatsController
{
    // ----- GET -----
    #[Route('/stats/get')]
    public function get_stats()
    {
        $stats_type = empty($_GET['stats_type']) ? NULL : htmlspecialchars($_GET['stats_type']);
        $sensor_id = empty($_GET['sensor_id']) ? NULL : htmlspecialchars($_GET['sensor_id']);
        $session_id = empty($_GET['session_id']) ? NULL : htmlspecialchars($_GET['session_id']);
        $max_points = empty($_GET['max_points']) ? 100 : intval($_GET['max_points']);

        if ($stats_type == 'noise') {
            if ($session_id && $sensor_id) {
                return $this->get_noise_sensor_session($sensor_id, $session_id, $max_points);
            } else if ($sensor_id) {
                return $this->get_noise_sensor($sensor_id, $max_points);
            } else if ($session_id) {
                return $this->get_noise_session($session_id, $max_points);
            } else {
                return JSONResponse('error', 'Paramètre manquant [noise]');
            }
        } else if ($stats_type == 'people') {
            if ($session_id) {
                return $this->get_people_session($session_id, $max_points);
            } else {
                return JSONResponse('error', 'Paramètre manquant [people]');
            }
        } else {
            // No stats_type parameter, return a view to show possible graphics
            require_once 'model/db-sensor.php';
            require_once 'model/db-session.php';

            $GLOBALS['sensors'] = get_sensors();
            $GLOBALS['sessions'] = get_sessions();
            require_view('view/show-stats.php');
            unset($GLOBALS['sensors']);
            unset($GLOBALS['sessions']);
        }
    }

    // ----- POST -----
    #[Route('/update-stats-timepoint')]
    #[Method('POST')]
    public function update_stats_timepoint()
    {
        if (!isset($_POST['noise_recording_id']) || !isset($_POST['timepoint'])) {
            return JSONResponse('error', 'Paramètres manquants');
        }

        require_once 'model/db-statistics.php';
        $noise_recording_id = $_POST['noise_recording_id'];
        $timepoint = $_POST['timepoint'];
        if (!update_stats_timepoint_by_id($noise_recording_id, $timepoint)) {
            return JSONResponse('error', 'L\'heure n\'a pas pu être mise à jour');
        } else {
            return JSONResponse('success', 'L\'heure a bien été mise à jour');
        }
    }

    #[Route('/update-stats-level')]
    #[Method('POST')]
    public function update_stats_level()
    {
        if (!isset($_POST['noise_recording_id']) || !isset($_POST['noise_level'])) {
            return JSONResponse('error', 'Paramètres manquants');
        }

        require_once 'model/db-statistics.php';
        $noise_recording_id = $_POST['noise_recording_id'];
        $noise_level = $_POST['noise_level'];
        if (!update_stats_level_by_id($noise_recording_id, $noise_level)) {
            return JSONResponse('error', 'Le niveau sonore n\'a pas pu être mis à jour');
        } else {
            return JSONResponse('success', 'Le niveau sonore a bien été mis à jour');
        }
    }

    // ----- Private Methods -----
    private function get_noise_sensor_session($sensor_id, $session_id, $max_points)
    {
        require_once 'model/db-session.php';
        if (!session_exists($session_id)) {
            return JSONResponse('error', 'La session n\'existe pas');
        }

        require_once 'model/db-sensor.php';
        if (!sensor_exists($sensor_id)) {
            return JSONResponse('error', 'Le capteur n\'existe pas');
        }

        require_once 'model/db-statistics.php';
        $chart1 = db_get_noise_sensor_session($sensor_id, $session_id, $max_points);

        $timepoints = [];
        $noise_levels = [];
        $i = 1;

        foreach ($chart1 as $row) {
            array_push($timepoints, $i++);
            array_push($noise_levels, $row['noise_level']);
        }

        return JSONResponseFromArray([
            'x' => $timepoints,
            'y' => $noise_levels
        ]);
    }

    private function get_noise_sensor($sensor_id, $max_points)
    {
        require_once 'model/db-sensor.php';
        if (!sensor_exists($sensor_id)) {
            return JSONResponse('error', 'Le capteur n\'existe pas');
        }

        require_once 'model/db-statistics.php';
        $chart1 = db_get_noise_sensor($sensor_id, $max_points);

        $timepoints = [];
        $noise_levels = [];
        $i = 1;

        foreach ($chart1 as $row) {
            array_push($timepoints, $i++);
            array_push($noise_levels, $row['noise_level']);
        }

        return JSONResponseFromArray([
            'x' => $timepoints,
            'y' => $noise_levels
        ]);
    }

    private function get_noise_session($session_id, $max_points)
    {
        require_once 'model/db-session.php';
        if (!session_exists($session_id)) {
            return JSONResponse('error', 'La session n\'existe pas');
        }

        require_once 'model/db-statistics.php';
        $chart1 = db_get_noise_session($session_id, $max_points);

        $timepoints = [];
        $noise_levels = [];
        $i = 1;
        foreach ($chart1 as $row) {
            array_push($timepoints, $i++);
            array_push($noise_levels, $row['noise_level']);
        }

        return JSONResponseFromArray([
            'x' => $timepoints,
            'y' => $noise_levels
        ]);
    }

    private function get_people_session($session_id, $max_points)
    {
        require_once 'model/db-session.php';
        if (!session_exists($session_id)) {
            return JSONResponse('error', 'La session n\'existe pas');
        }

        require_once 'model/db-statistics.php';
        $chart1 = db_get_people_session($session_id, $max_points);

        $timepoints = [];
        $nb_people = [];
        $i = 1;
        foreach ($chart1 as $row) {
            array_push($timepoints, $i++);
            array_push($nb_people, $row['nb_people']);
        }

        return JSONResponseFromArray([
            'x' => $timepoints,
            'y' => $nb_people
        ]);
    }
}
