<?php
global $forum_topics;
global $nb_messages;
$GLOBALS['PAGE_TITLE'] = 'Forum Topics';
addCSS('forum-index.css');
require_once 'controller/functions/session.php';
require_view('view/header.php');
?>


<main>
    <h1>Forum Topics</h1>
    <p>There is <?= count($forum_topics) ?> topics(s) currently in the forum.</p>

    <table>
        <thead>
            <tr>
                <th>Topic</th>
                <th>Create Date</th>
                <!-- <th>Created By</th>
            <th>Approved By</th> -->
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
            <legend>Add new topic to the forum</legend>
            <p>
                <label for="topic">Topic</label>
                <input type="text" name="topic" id="topic" required>
            </p>
            <?php if (!is_the_session_started()) : ?>
                <input class="BigButton" type="submit" value="Create Topic" disabled>
                <p>You must be logged in to create a topic.</p>
            <?php else : ?>
                <input class="BigButton" type="submit" value="Create Topic">
            <?php endif; ?>
        </fieldset>

        <div id="feedback"></div>
    </form>
</main>

<?php
require_view('view/footer.php');
?>