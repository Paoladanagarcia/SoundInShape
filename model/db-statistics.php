<?php

global $PDO;
require_once 'model/db-connection.php';

function db_get_noise_sensor_session($sensor_id, $session_id, $max_points)
{
    // get:
    //  - noise_recording_id
    //  - timepoint
    //  - noise_level
    //  - statistic_id
    //  - sensor_id
    //  - session_id

    global $PDO;
    $query = $PDO->prepare(
        "SELECT * FROM noise_recording 
        WHERE sensor_id = :sensor_id
        AND session_id = :session_id
        ORDER BY timepoint DESC
        LIMIT :max_points"
    );
    $query->bindValue('sensor_id', $sensor_id, PDO::PARAM_INT);
    $query->bindValue('session_id', $session_id, PDO::PARAM_INT);
    $query->bindValue('max_points', $max_points, PDO::PARAM_INT);
    $query->execute();
    return $query->fetchAll(PDO::FETCH_ASSOC);
}

function db_get_noise_sensor($sensor_id, $max_points)
{
    // get:
    //  - noise_recording_id	
    //  - timepoint	
    //  - noise_level	
    //  - statistic_id	
    //  - session_id
    global $PDO;
    $query = $PDO->prepare(
        "SELECT * FROM noise_recording 
        WHERE sensor_id = :sensor_id 
        ORDER BY timepoint DESC 
        LIMIT :max_points"
    );
    $query->bindValue('sensor_id', $sensor_id, PDO::PARAM_INT);
    $query->bindValue('max_points', $max_points, PDO::PARAM_INT);
    $query->execute();
    return $query->fetchAll();
}

function db_get_noise_session($session_id, $max_points)
{
    // get:
    //  - noise_recording_id
    //  - timepoint
    //  - noise_level
    //  - statistic_id
    //  - sensor_id
    //  - session_id

    global $PDO;
    $query = $PDO->prepare(
        "SELECT * FROM noise_recording 
        WHERE session_id = :session_id 
        ORDER BY timepoint DESC 
        LIMIT :max_points"
    );
    $query->bindValue('session_id', $session_id, PDO::PARAM_INT);
    $query->bindValue('max_points', $max_points, PDO::PARAM_INT);
    $query->execute();
    return $query->fetchAll(PDO::FETCH_ASSOC);
}

function db_get_people_session($session_id, $max_points)
{
    // get:
    //  - crowd_id
    //  - timepoint
    //  - nb_people
    //  - session_id
    //  - statistic_id

    global $PDO;
    $query = $PDO->prepare(
        "SELECT * FROM crowd 
        WHERE session_id = :session_id 
        ORDER BY timepoint DESC 
        LIMIT :max_points"
    );
    $query->bindValue('session_id', $session_id, PDO::PARAM_INT);
    $query->bindValue('max_points', (int) $max_points, PDO::PARAM_INT);
    $query->execute();
    return $query->fetchAll(PDO::FETCH_ASSOC);
}

function update_stats_timepoint_by_id($noise_recording_id, $timepoint)
{
    global $PDO;
    $query = $PDO->prepare('UPDATE noise_recording SET timepoint = :timepoint WHERE noise_recording_id = :noise_recording_id');
    return $query->execute(array(
        'timepoint' => $timepoint,
        'noise_recording_id' => $noise_recording_id
    ));
}

function update_stats_level_by_id($noise_recording_id, $noise_level)
{
    global $PDO;
    $query = $PDO->prepare('UPDATE noise_recording SET noise_level = :noise_level WHERE noise_recording_id = :noise_recording_id');
    return $query->execute(array(
        'noise_level' => $noise_level,
        'noise_recording_id' => $noise_recording_id
    ));
}

function get_noise_by_sensor($sensor_id)
{
    global $PDO;
    $query = $PDO->prepare(
        "SELECT * FROM noise_recording 
        WHERE sensor_id = :sensor_id 
        ORDER BY timepoint DESC"
    );
    $query->bindValue('sensor_id', $sensor_id, PDO::PARAM_INT);
    $query->execute();
    return $query->fetchAll(PDO::FETCH_ASSOC);
}


function fill_noise_with_random_values()
{
    // timepoint is between 2024-01-01 00:00:00 and 2024-06-30 23:59:59
    // noise level is between 40 and 60

    // feeding 100 rows by sessnsor, and also by séance
    global $PDO;

    $query = $PDO->prepare('SELECT session_id FROM session');
    $query->execute();
    $sessions = $query->fetchAll(PDO::FETCH_ASSOC);

    $query = $PDO->prepare('SELECT sensor_id FROM sensor');
    $query->execute();
    $sensors = $query->fetchAll(PDO::FETCH_ASSOC);

    foreach ($sessions as $session) {
        // Fake noise, just for pretty charts, and session suggestions
        $noise_center = rand(30, 90);
        $dispersion = rand(10, 30);

        foreach ($sensors as $sensor) {
            for ($i = 0; $i < 100; $i++) {
                // IMPORTANT: error constraint violation
                // We need to check that sensor_has_session table has the correspondance (sensor_id, session_id)
                $query = $PDO->prepare('SELECT * FROM sensor_has_session WHERE sensor_id = :sensor_id AND session_id = :session_id');
                $query->execute(array(
                    'sensor_id' => $sensor['sensor_id'],
                    'session_id' => $session['session_id']
                ));
                $sensor_has_session = $query->fetch(PDO::FETCH_ASSOC);

                if ($sensor_has_session) {
                    $start_date = '00:00:00';
                    $end_date = '23:59:59';
                    $timepoint = date('Y-m-d H:i:s', rand(strtotime($start_date), strtotime($end_date)));

                    $noise_level = rand($noise_center - $dispersion, $noise_center + $dispersion);

                    $query = $PDO->prepare(
                        'INSERT INTO noise_recording (timepoint, noise_level, sensor_id, session_id)
                    VALUES (:timepoint, :noise_level, :sensor_id, :session_id)'
                    );
                    $query->execute(array(
                        'timepoint' => $timepoint,
                        'noise_level' => $noise_level,
                        'sensor_id' => $sensor['sensor_id'],
                        'session_id' => $session['session_id']
                    ));
                }
            }
        }
    }
}

function fill_crowd_with_random_values()
{
    global $PDO;

    $query = $PDO->prepare('SELECT session_id FROM session');
    $query->execute();
    $sessions = $query->fetchAll(PDO::FETCH_ASSOC);

    foreach ($sessions as $session) {
        for ($i = 0; $i < 100; $i++) {
            $start_date = '2022-01-01 00:00:00';
            $end_date = '2022-12-31 23:59:59';

            $timepoint = date('Y-m-d H:i:s', rand(strtotime($start_date), strtotime($end_date)));

            $nb_people = rand(10, 60);

            $query = $PDO->prepare(
                'INSERT INTO crowd (timepoint, nb_people, session_id)
                    VALUES (:timepoint, :nb_people, :session_id)'
            );
            $query->execute(array(
                'timepoint' => $timepoint,
                'nb_people' => $nb_people,
                'session_id' => $session['session_id']
            ));
        }
    }
}

function add_one_noise()
{
    global $PDO;

    $start_date = '2023-01-01 00:00:00';
    $end_date = '2023-12-31 23:59:59';

    $noise_center = rand(30, 90);
    $dispersion = rand(10, 30);
    $noise_level = rand($noise_center - $dispersion, $noise_center + $dispersion);

    $timepoint = date('Y-m-d H:i:s', rand(strtotime($start_date), strtotime($end_date)));

    $query = $PDO->prepare(
        'INSERT INTO noise_recording (timepoint, noise_level, sensor_id, session_id)
                    VALUES (:timepoint, :noise_level, :sensor_id, :session_id)'
    );
    $query->execute(array(
        'timepoint' => $timepoint,
        'noise_level' => $noise_level,
        'sensor_id' => 1,
        'session_id' => 3
    ));

    // return the id of the row
    return $PDO->lastInsertId();
}
