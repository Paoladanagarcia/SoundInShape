<?php

global $PDO;
require_once 'model/db-connection.php';

function get_faq()
{
    global $PDO;
    $query = $PDO->prepare('SELECT * FROM faq');
    $query->execute();
    return $query->fetchAll(PDO::FETCH_ASSOC);
}

function add_faq($question, $answer)
{
    global $PDO;
    $query = $PDO->prepare(
        'INSERT INTO faq (question, answer)
        VALUES (:question, :answer)'
    );
    $query->execute(array(
        'question' => $question,
        'answer' => $answer
    ));

    return $query->rowCount() > 0;
}

function update_faq($faq_id, $question, $answer)
{
    global $PDO;
    $query = $PDO->prepare(
        'UPDATE faq SET question = :question, answer = :answer
        WHERE faq_id = :faq_id'
    );
    $query->execute(array(
        'question' => $question,
        'answer' => $answer,
        'faq_id' => $faq_id
    ));

    return $query->rowCount() > 0;
}

function delete_faq($faq_id)
{
    global $PDO;
    $query = $PDO->prepare(
        'DELETE FROM faq
        WHERE faq_id = :faq_id'
    );
    $query->execute(array(
        'faq_id' => $faq_id
    ));

    // return true if something got deleted
    return $query->rowCount() > 0;
}
