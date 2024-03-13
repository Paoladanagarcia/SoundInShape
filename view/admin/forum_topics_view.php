<?php
global $topics;
$GLOBALS['PAGE_TITLE'] = 'Sujets du forum';
addCSS('dashboard.css');
require_view('view/header.php');
?>

<h1><?= $GLOBALS['PAGE_TITLE'] ?></h1>

<!-- display topic information: forum_topic_id
topic
create_date
is_approved
admin_id
user_id -->

<table>
    <thead>
        <tr>
            <th>Sujet</th>
            <th>Créé par</th>
            <th>Date de création</th>
            <th>Confirmer</th>
            <th>Gérer</th>
            <th>Voir les messages</th>
            <th>Supprimer</th>
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
                        <p>Confirmé</p>
                    <?php else : ?>
                        <form action="<?= url('/approve-topic') ?>" method="POST">
                            <input type="hidden" name="topic_id" value="<?= $topic['forum_topic_id'] ?>">
                            <input type="submit" value="Confirmer">
                        </form>
                    <?php endif; ?>
                </td>
                <td>
                    <a href="<?= url('/admin/forum-topics?id=' . $topic['forum_topic_id']) ?>">Gérer</a>
                </td>
                <td>
                    <a href="<?= url('/admin/forum-messages?topic_id=' . $topic['forum_topic_id']) ?>">Voir les messages</a>
                </td>
                <td>
                    <form action="<?= url('/delete-topic') ?>" method="POST">
                        <input type="hidden" name="topic_id" value="<?= $topic['forum_topic_id'] ?>">
                        <input type="submit" value="Supprimer">
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>


<?php
require_view('view/footer.php');
?>