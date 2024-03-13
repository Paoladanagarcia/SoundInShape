<?php
global $forum_topic;
global $forum_messages;
$GLOBALS['PAGE_TITLE'] = "Sujet du forum : {$forum_topic['topic']}";
addCSS('forum-topic.css');
require_view('view/header.php');
?>


<main>
    <h1><?= $forum_topic['topic'] ?></h1>
    <p>Il y a <?= count($forum_messages) ?> message(s) dans ce sujet.</p>

    <ul class="msg-list">
        <?php foreach ($forum_messages as $msg) : ?>
            <li class="forum-msg">
                <p>L'utilisateur <?= $msg['user_id'] ?> a envoyé à <?= $msg['post_date'] ?> le message :</p>
                <p><b><?= $msg['message'] ?></b></p>
                <p>Ce message est identifié par <?= $msg['forum_message_id'] ?> et concerne le sujet <?= $msg['forum_topic_id'] ?></p>
            </li>
        <?php endforeach; ?>
    </ul>

    <form id="form-forum-msg" action="post-forum-message">
        <fieldset>
            <legend>Envoyer un nouveau message</legend>
            <p>
                <label for="message">Message</label>
                <textarea name="message" id="message" required></textarea>
            </p>
            <input type="hidden" name="topic_id" value="<?= $forum_topic['forum_topic_id'] ?>">

            <?php if (is_the_session_started()) : ?>
                <p><input class="BigButton" type="submit" value="Envoyer le message"></p>
            <?php else : ?>
                <p>Vous devez être connecté pour envoyer un message.</p>
                <p><input class="BigButton" type="submit" value="Envoyer le message" disabled></p>
            <?php endif; ?>
        </fieldset>
    </form>

    <p><a href="forum">Retour à la liste des forums</a></p>
</main>

<?php
require_view('view/footer.php');
?>