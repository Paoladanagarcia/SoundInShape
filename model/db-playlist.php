<?php

global $PDO;
require_once 'model/db-connection.php';

function get_playlist()
{
    global $PDO;

    $query = $PDO->prepare('SELECT * FROM playlist');
    $query->execute();
    $result = $query->fetchAll(PDO::FETCH_ASSOC);

    return $result;
}
