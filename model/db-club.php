<?php


global $PDO;
require_once 'model/db-connection.php';

function get_all_clubs()
{
    global $PDO;
    $query = 'SELECT * FROM club';
    $stmt = $PDO->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll();
}

function get_club(int $club_id)
{
    global $PDO;
    $query = 'SELECT * FROM club WHERE club_id = :club_id';
    $stmt = $PDO->prepare($query);
    $stmt->execute(array(
        'club_id' => $club_id
    ));
    return $stmt->fetch();
}

function update_club(int $club_id, string $name, int $nb_rooms, string $opening_hour, string $closing_hour)
{
    global $PDO;
    $query = 'UPDATE club SET name = :name, nb_rooms = :nb_rooms, opening_hour = :opening_hour, closing_hour = :closing_hour WHERE club_id = :club_id';
    $stmt = $PDO->prepare($query);
    $stmt->execute(array(
        'club_id' => $club_id,
        'name' => $name,
        'nb_rooms' => $nb_rooms,
        'opening_hour' => $opening_hour,
        'closing_hour' => $closing_hour
    ));

    return $stmt->rowCount() > 0;
}

function create_club($club_data)
{
    global $PDO;
    $query = 'INSERT INTO club (name, nb_rooms, opening_hour, closing_hour) VALUES (:name, :nb_rooms, :opening_hour, :closing_hour)';
    $stmt = $PDO->prepare($query);
    $stmt->execute(array(
        'name'          => $club_data['name'],
        'nb_rooms'      => $club_data['nb_rooms'],
        'opening_hour'  => $club_data['opening_hour'],
        'closing_hour'  => $club_data['closing_hour']
    ));

    return $stmt->rowCount() > 0;
}

function delete_club(int $club_id)
{
    global $PDO;
    $query = 'DELETE FROM club WHERE club_id = :club_id';
    $stmt = $PDO->prepare($query);
    $stmt->execute(array(
        'club_id' => $club_id
    ));

    return $stmt->rowCount() > 0;
}
