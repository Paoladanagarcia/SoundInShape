<?php

global $PDO;
require_once 'model/db-connection.php';

function get_all_topics()
{
    global $PDO;
    return $PDO->query('SELECT * FROM forum_topic')->fetchAll();
}

function get_all_confirmed_topics()
{
    global $PDO;
    return $PDO->query('SELECT * FROM forum_topic WHERE is_approved = 1')->fetchAll();
}

function is_topic_approved($topic_id)
{
    global $PDO;
    $query = $PDO->prepare('SELECT is_approved FROM forum_topic WHERE forum_topic_id = :topic_id');
    $query->execute(['topic_id' => $topic_id]);
    return $query->fetchColumn();
}

function get_topic($topic_id)
{
    global $PDO;
    $query = $PDO->prepare('SELECT * FROM forum_topic WHERE forum_topic_id = :topic_id');
    $query->execute(['topic_id' => $topic_id]);
    return $query->fetch();
}

function topic_exists($topic_id)
{
    global $PDO;
    $query = $PDO->prepare('SELECT COUNT(*) FROM forum_topic WHERE forum_topic_id = :topic_id');
    $query->execute(['topic_id' => $topic_id]);
    return $query->fetchColumn() > 0;
}

function get_nb_messages_for_topic($topic_id)
{
    global $PDO;
    $query = $PDO->prepare('SELECT COUNT(*) FROM forum_message WHERE forum_topic_id = :topic_id');
    $query->execute(['topic_id' => $topic_id]);
    return $query->fetchColumn();
}

function get_all_messages_for_topic($topic_id)
{
    global $PDO;
    $query = $PDO->prepare('SELECT * FROM forum_message WHERE forum_topic_id = :topic_id');
    $query->execute(['topic_id' => $topic_id]);
    return $query->fetchAll();
}

function create_topic($topic, $user_id)
{
    global $PDO;
    $query = $PDO->prepare('INSERT INTO forum_topic (topic, user_id) VALUES (:topic, :user_id)');
    $result = $query->execute([
        'topic' => $topic,
        'user_id' => $user_id
    ]);
    if (!$result) {
        return false;
    }
    return $PDO->lastInsertId();
}

function create_message($message, $user_id, $topic_id)
{
    global $PDO;
    $query = $PDO->prepare('INSERT INTO forum_message (message, forum_topic_id, user_id) VALUES (:message, :topic_id, :user_id)');
    $result = $query->execute([
        'message' => $message,
        'topic_id' => $topic_id,
        'user_id' => $user_id
    ]);
    if (!$result) {
        return false;
    }
    return $PDO->lastInsertId();
}

function get_unconfirmed_topics()
{
    global $PDO;
    $query = $PDO->prepare('SELECT * FROM forum_topic WHERE is_approved = 0');
    $query->execute();
    return $query->fetchAll();
}

function approve_topic(int $topic_id, int $admin_approving): bool
{
    global $PDO;
    $query = $PDO->prepare('UPDATE forum_topic 
        SET is_approved = 1, admin_id = :admin_id 
        WHERE forum_topic_id = :topic_id');
    return $query->execute([
        'topic_id' => $topic_id,
        'admin_id' => $admin_approving
    ]);
}

function update_topic(int $topic_id, array $topic_data): bool
{
    global $PDO;
    $query = $PDO->prepare('UPDATE forum_topic 
        SET topic = :topic, create_date = :create_date, is_approved = :is_approved, admin_id = :admin_id, user_id = :user_id 
        WHERE forum_topic_id = :topic_id');
    return $query->execute([
        'topic_id' => $topic_id,
        'topic' => $topic_data['topic'],
        'create_date' => $topic_data['create_date'],
        'is_approved' => $topic_data['is_approved'],
        'admin_id' => $topic_data['admin_id'],
        'user_id' => $topic_data['user_id']
    ]);
}

function delete_topic(int $topic_id): bool
{
    global $PDO;

    // Empty every messages before
    $query = $PDO->prepare('DELETE FROM forum_message WHERE forum_topic_id = :topic_id');
    $query->execute(['topic_id' => $topic_id]);

    // Delete topic
    $query = $PDO->prepare('DELETE FROM forum_topic WHERE forum_topic_id = :topic_id');
    return $query->execute(['topic_id' => $topic_id]);
}

function update_message(int $message_id, string $message): bool
{
    global $PDO;
    $query = $PDO->prepare('UPDATE forum_message 
        SET message = :message 
        WHERE forum_message_id = :message_id');
    return $query->execute([
        'message_id' => $message_id,
        'message' => $message
    ]);
}

function delete_message(int $message_id): bool
{
    global $PDO;
    $query = $PDO->prepare('DELETE FROM forum_message WHERE forum_message_id = :message_id');
    return $query->execute(['message_id' => $message_id]);
}
