<?php
global $forum_topics;
global $nb_messages;
$GLOBALS['PAGE_TITLE'] = 'Liste des sujets du forum';
addCSS('forum-index.css');
require_once 'controller/functions/session.php';
require_view('view/header.php');
?>


<main>
    <h1>Liste des forums</h1>
    <p>Il y a <?= count($forum_topics) ?> sujet(s) actuellement dans le forum.</p>

    <table>
        <thead>
            <tr>
                <th>Sujet</th>
                <th>Date de création</th>
                <!-- <th>Créé par</th>
            <th>Approuvé par</th> -->
                <th>Messages</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($forum_topics as $topic) : ?>
                <tr onclick="window.location.href = 'forum?topic=<?= $topic['forum_topic_id'] ?>'">
                    <td><?= $topic['topic'] ?></td>
                    <td><?= $topic['create_date'] ?></td>
                    <!-- <td><?= $topic['user_id'] ?></td>
            <td><?= $topic['is_approved'] ? $topic['admin_id'] : 'Non approuvé' ?></td> -->
                    <td><?= $nb_messages[$topic['forum_topic_id']] ?> message(s)</td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <form id="new-topic-form" action="post-forum-topic">
        <fieldset>
            <legend>Créer un nouveau sujet</legend>
            <p>
                <label for="topic">Sujet</label>
                <input type="text" name="topic" id="topic" required>
            </p>
            <?php if (!is_the_session_started()) : ?>
                <input class="BigButton" type="submit" value="Créer le sujet" disabled>
                <p>Vous devez être connecté pour créer un nouveau sujet.</p>
            <?php else : ?>
                <input class="BigButton" type="submit" value="Créer le sujet">
            <?php endif; ?>
        </fieldset>

        <div id="feedback"></div>
    </form>
</main>

<?php
require_view('view/footer.php');
?>