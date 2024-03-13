<?php

global $PDO;
require_once 'model/db-connection.php';

function get_legal()
{
    global $PDO;
    $query = $PDO->prepare('SELECT * FROM legal ORDER BY legal_id ASC');
    $query->execute();
    return $query->fetchAll(PDO::FETCH_ASSOC);
}

function add_legal($title, $content)
{
    // title, content
    global $PDO;
    $query = $PDO->prepare('INSERT INTO legal (title, content) VALUES (:title, :content)');
    $query->execute(array(
        'title' => $title,
        'content' => $content
    ));

    return $query->rowCount() > 0;
}

function update_legal($legal_id, $title, $content)
{
    // legal_id, title, content
    global $PDO;
    $query = $PDO->prepare('UPDATE legal SET title = :title, content = :content WHERE legal_id = :legal_id');
    $query->execute(array(
        'title' => $title,
        'content' => $content,
        'legal_id' => $legal_id
    ));

    return $query->rowCount() > 0;
}

function delete_legal($legal_id)
{
    // legal_id
    global $PDO;
    $query = $PDO->prepare('DELETE FROM legal WHERE legal_id = :legal_id');
    $query->execute(array(
        'legal_id' => $legal_id
    ));

    return $query->rowCount() > 0;
}
