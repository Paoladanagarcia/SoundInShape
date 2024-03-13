<?php
global $topics;
$GLOBALS['PAGE_TITLE'] = 'Forum Topics';
addCSS('dashboard.css');
require_view('view/header.php');
?>

<h1><?= $GLOBALS['PAGE_TITLE'] ?></h1>

<table>
    <thead>
        <tr>
            <th>Topic</th>
            <th>Created By</th>
            <th>Creation Date</th>
            <th>Confirm</th>
            <th>Manage</th>
            <th>View Messages</th>
            <th>Delete</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($topics as $topic) : ?>
            <tr>
                <td><?= $topic['topic'] ?></td>
                <td><?= $topic['user_id'] ?></td>
                <td><?= $topic['create_date'] ?></td>
                <td>
                    <?php if ($topic['is_approved'] == 1) : ?>
                        <p>Confirmed</p>
                    <?php else : ?>
                        <form action="<?= url('/approve-topic') ?>" method="POST">
                            <input type="hidden" name="topic_id" value="<?= $topic['forum_topic_id'] ?>">
                            <input type="submit" value="Confirm">
                        </form>
                    <?php endif; ?>
                </td>
                <td>
                    <a href="<?= url('/admin/forum-topics?id=' . $topic['forum_topic_id']) ?>">Manage</a>
                </td>
                <td>
                    <a href="<?= url('/admin/forum-messages?topic_id=' . $topic['forum_topic_id']) ?>">View Messages</a>
                </td>
                <td>
                    <form action="<?= url('/delete-topic') ?>" method="POST">
                        <input type="hidden" name="topic_id" value="<?= $topic['forum_topic_id'] ?>">
                        <input type="submit" value="Delete">
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>


<?php
require_view('view/footer.php');
?>