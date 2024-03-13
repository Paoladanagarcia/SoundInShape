<?php

global $PDO;
require_once 'model/db-connection.php';

function get_sessions()
{
    global $PDO;
    $query = 'SELECT * FROM session';
    $stmt = $PDO->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function get_session(int $session_id)
{
    global $PDO;
    $query = 'SELECT * FROM session WHERE session_id = :session_id';
    $stmt = $PDO->prepare($query);
    $stmt->bindParam(':session_id', $session_id);
    $stmt->execute();
    return $stmt->fetch();
}

function session_exists(int $session_id)
{
    global $PDO;
    $query = 'SELECT COUNT(*) FROM session WHERE session_id = :session_id';
    $stmt = $PDO->prepare($query);
    $stmt->bindParam(':session_id', $session_id);
    $stmt->execute();
    return $stmt->fetchColumn() > 0;
}

function update_session(
    $session_id,
    $start_hour,
    $end_hour,
    $voted_noise_level,
    $time_noise_level_approved,
    $club_id
) {
    global $PDO;
    $query = 'UPDATE session SET
        start_hour = :start_hour,
        end_hour = :end_hour,
        voted_noise_level = :voted_noise_level,
        time_noise_level_approved = :time_noise_level_approved,
        club_id = :club_id
        WHERE session_id = :session_id';
    $stmt = $PDO->prepare($query);
    $stmt->bindParam(':session_id', $session_id);
    $stmt->bindParam(':start_hour', $start_hour);
    $stmt->bindParam(':end_hour', $end_hour);
    $stmt->bindParam(':voted_noise_level', $voted_noise_level);
    $stmt->bindParam(':time_noise_level_approved', $time_noise_level_approved);
    $stmt->bindParam(':club_id', $club_id);
    return $stmt->execute();
}

function delete_session(int $session_id)
{
    global $PDO;
    $query = 'DELETE FROM session WHERE session_id = :session_id';
    $stmt = $PDO->prepare($query);
    $stmt->bindParam(':session_id', $session_id);
    return $stmt->execute();
}

function
add_session(
    $start_hour,
    $end_hour,
    $voted_noise_level,
    $time_noise_level_approved,
    $club_id
) {
    global $PDO;
    $query = 'INSERT INTO session (
        start_hour,
        end_hour,
        voted_noise_level,
        time_noise_level_approved,
        club_id
    ) VALUES (
        :start_hour,
        :end_hour,
        :voted_noise_level,
        :time_noise_level_approved,
        :club_id
    )';
    $stmt = $PDO->prepare($query);
    $stmt->execute([
        ':start_hour' => $start_hour,
        ':end_hour' => $end_hour,
        ':voted_noise_level' => $voted_noise_level,
        ':time_noise_level_approved' => $time_noise_level_approved,
        ':club_id' => $club_id
    ]);

    return $stmt->rowCount() > 0;
}
