<?php

global $PDO;
require_once 'model/db-connection.php';

function get_cgu()
{
    global $PDO;
    $query = $PDO->prepare('SELECT * FROM cgu ORDER BY cgu_id ASC');
    $query->execute();
    return $query->fetchAll(PDO::FETCH_ASSOC);
}

function add_cgu($title, $content)
{
    // title, content
    global $PDO;
    $query = $PDO->prepare('INSERT INTO cgu (title, content) VALUES (:title, :content)');
    $query->execute(array(
        'title' => $title,
        'content' => $content
    ));

    return $query->rowCount() > 0;
}

function update_cgu($cgu_id, $title, $content)
{
    // cgu_id, title, content
    global $PDO;
    $query = $PDO->prepare('UPDATE cgu SET title = :title, content = :content WHERE cgu_id = :cgu_id');
    $query->execute(array(
        'title' => $title,
        'content' => $content,
        'cgu_id' => $cgu_id
    ));

    return $query->rowCount() > 0;
}

function delete_cgu($cgu_id)
{
    // cgu_id
    global $PDO;
    $query = $PDO->prepare('DELETE FROM cgu WHERE cgu_id = :cgu_id');
    $query->execute(array(
        'cgu_id' => $cgu_id
    ));

    return $query->rowCount() > 0;
}
