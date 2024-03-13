<?php
global $topic;
$GLOBALS['PAGE_TITLE'] = 'Manage Topic';
addCSS('dashboard.css');
require_view('view/header.php');
?>

<h1><?= $GLOBALS['PAGE_TITLE'] ?></h1>

<div class="container">
    <div class="form-container">
        <form action="<?= url('/manage-forum-topic') ?>" method="post">
            <input type="hidden" name="topic_id" value="<?= $topic['forum_topic_id'] ?>" />
            <div class="form-group">
                <label for="topic">Topic</label>
                <input type="text" name="topic" id="topic" value="<?= $topic['topic'] ?>" />
            </div>
            <div class="form-group">
                <label for="create_date">Creation Date</label>
                <input type="datetime-local" name="create_date" id="create_date" value="<?= $topic['create_date'] ?>" />
            </div>
            <div class="form-group">
                <label for="is_approved">Approved</label>
                <input type="checkbox" name="is_approved" id="is_approved" <?php if ($topic['is_approved'] == 1) : ?> checked <?php endif; ?> />
            </div>
            <div class="form-group">
                <label for="admin_id">Admin</label>
                <input type="text" name="admin_id" id="admin_id" value="<?= $topic['admin_id'] ?>" />
            </div>
            <div class="form-group">
                <label for="user_id">User</label>
                <input type="text" name="user_id" id="user_id" value="<?= $topic['user_id'] ?>" />
            </div>

            <div class="form-group">
                <input class="BigButton" type="submit" value="Submit" />
            </div>
        </form>
    </div>
</div>

<?php
require_view('view/footer.php');
?>