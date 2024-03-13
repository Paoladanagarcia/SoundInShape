<?php
global $topic;
global $messages;
$GLOBALS['PAGE_TITLE'] = 'Forum Message';
addCSS('dashboard.css');
require_view('view/header.php');
?>

<h1><?= $GLOBALS['PAGE_TITLE'] ?></h1>

<table>
    <thead>
        <tr>
            <th>Created By</th>
            <th>Creation Date</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($messages as $message) : ?>
            <tr>
                <td><?= $message['user_id'] ?></td>
                <td><?= $message['post_date'] ?></td>
                <td>
                    <form action="<?= url('/edit-message') ?>" method="post">
                        <textarea name="forum-message" id="forum-message" cols="30" rows="5"><?php echo $message['message']; ?></textarea>
                        <input type="hidden" name="message_id" value="<?= $message['forum_message_id'] ?>">
                        <input type="hidden" name="topic_id" value="<?= $message['forum_topic_id'] ?>">
                        <input type="submit" value="Edit" class="BigButton">
                    </form>
                </td>
                <td>
                    <form action="<?= url('/delete-message') ?>" method="post">
                        <input type="hidden" name="message_id" value="<?= $message['forum_message_id'] ?>">
                        <input type="hidden" name="topic_id" value="<?= $message['forum_topic_id'] ?>">
                        <input type="submit" value="Delete">
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<p><a href="<?= url('/admin/forum-topics') ?>">Back to the list of topics</a></p>

<?php
require_view('view/footer.php');
?>