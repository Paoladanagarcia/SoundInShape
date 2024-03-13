<?php
global $forum_topic;
global $forum_messages;
$GLOBALS['PAGE_TITLE'] = "Forum Topic: {$forum_topic['topic']}";
addCSS('forum-topic.css');
require_view('view/header.php');
?>


<main>
    <h1><?= $forum_topic['topic'] ?></h1>
    <p>There is <?= count($forum_messages) ?> message(s) currently for this topic.</p>

    <ul class="msg-list">
        <?php foreach ($forum_messages as $msg) : ?>
            <li class="forum-msg">
                <p>The user <?= $msg['user_id'] ?> sent at <?= $msg['post_date'] ?> the following message:</p>
                <p><b><?= $msg['message'] ?></b></p>
                <p>This message is identified by <?= $msg['forum_message_id'] ?> for the topic <?= $msg['forum_topic_id'] ?></p>
            </li>
        <?php endforeach; ?>
    </ul>

    <form id="form-forum-msg" action="post-forum-message">
        <fieldset>
            <legend>Add new message</legend>
            <p>
                <label for="message">Message</label>
                <textarea name="message" id="message" required></textarea>
            </p>
            <input type="hidden" name="topic_id" value="<?= $forum_topic['forum_topic_id'] ?>">

            <?php if (is_the_session_started()) : ?>
                <p><input class="BigButton" type="submit" value="Send Message!"></p>
            <?php else : ?>
                <p>You must be logged in to send a message.</p>
                <p><input class="BigButton" type="submit" value="Send Message!" disabled></p>
            <?php endif; ?>
        </fieldset>
    </form>

    <p><a href="forum">Back to Forum List</a></p>
</main>

<?php
require_view('view/footer.php');
?>