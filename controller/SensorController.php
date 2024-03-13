<?php


class SensorController
{
    // ----- Constructor -----
    public function __construct()
    {
        require_once 'controller/functions/session.php';
        if (!is_admin_logged()) {
            echo 'Vous devez être connecté en tant qu\'administrateur pour accéder à la page des capteurs.';
            return;
        }
    }

    // ----- GET -----
    #[Route('/admin/sensors')]
    public function admin_view_sensors()
    {
        if (isset($_GET['sensor_id'])) {
            $sensor_id = intval($_GET['sensor_id']);
            $this->sensor_view_data($sensor_id);
            return;
        }

        require_once 'model/db-sensor.php';
        $GLOBALS['sensors'] = get_sensors();
        require_view('view/admin/sensors_view.php');
        unset($GLOBALS['sensors']);
    }

    // ----- POST -----


    // ----- Private methods -----
    public function sensor_view_data(int $sensor_id)
    {
        require_once 'model/db-statistics.php';
        $GLOBALS['sensor_id'] = $sensor_id;
        $GLOBALS['stats'] = get_noise_by_sensor($sensor_id);
        require_view('view/admin/sensor_view_data.php');
        unset($GLOBALS['sensor']);
    }
}
