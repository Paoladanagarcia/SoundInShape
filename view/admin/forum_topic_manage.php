<?php
global $topic;
$GLOBALS['PAGE_TITLE'] = 'Gérer le sujet';
addCSS('dashboard.css');
require_view('view/header.php');
?>

<h1><?= $GLOBALS['PAGE_TITLE'] ?></h1>

<!-- display a Bootstrap form to edit the following information:
topic
create_date
is_approved
admin_id
user_id
-->

<div class="container">
    <div class="form-container">
        <form action="<?= url('/manage-forum-topic') ?>" method="post">
            <input type="hidden" name="topic_id" value="<?= $topic['forum_topic_id'] ?>" />
            <div class="form-group">
                <label for="topic">Sujet</label>
                <input type="text" name="topic" id="topic" value="<?= $topic['topic'] ?>" />
            </div>
            <div class="form-group">
                <label for="create_date">Date de création</label>
                <input type="datetime-local" name="create_date" id="create_date" value="<?= $topic['create_date'] ?>" />
            </div>
            <div class="form-group">
                <label for="is_approved">Approuvé</label>
                <input type="checkbox" name="is_approved" id="is_approved" <?php if ($topic['is_approved'] == 1) : ?> checked <?php endif; ?> />
            </div>
            <div class="form-group">
                <label for="admin_id">Admin</label>
                <input type="text" name="admin_id" id="admin_id" value="<?= $topic['admin_id'] ?>" />
            </div>
            <div class="form-group">
                <label for="user_id">Utilisateur</label>
                <input type="text" name="user_id" id="user_id" value="<?= $topic['user_id'] ?>" />
            </div>

            <div class="form-group">
                <input class="BigButton" type="submit" value="Valider" />
            </div>
        </form>
    </div>
</div>

<?php
require_view('view/footer.php');
?>