<?php

global $PDO;
require_once 'model/db-connection.php';

function get_sensors()
{
    global $PDO;
    $query = 'SELECT * FROM sensor';
    $stmt = $PDO->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function get_sensor(int $sensor_id)
{
    global $PDO;
    $query = 'SELECT * FROM sensor WHERE sensor_id = :sensor_id';
    $stmt = $PDO->prepare($query);
    $stmt->bindParam(':sensor_id', $sensor_id);
    $stmt->execute();
    return $stmt->fetch();
}

function sensor_exists(int $sensor_id)
{
    global $PDO;
    $query = 'SELECT COUNT(*) FROM sensor WHERE sensor_id = :sensor_id';
    $stmt = $PDO->prepare($query);
    $stmt->bindParam(':sensor_id', $sensor_id);
    $stmt->execute();
    return $stmt->fetchColumn() > 0;
}
