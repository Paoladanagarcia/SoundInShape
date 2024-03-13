<?php
global $users;
$GLOBALS['PAGE_TITLE'] = 'Manage Users';
addCSS('dashboard.css');
require_view('view/header.php');
?>

<h1><?= $GLOBALS['PAGE_TITLE'] ?></h1>

<!-- Display a table id, first_name, last_name, mail from $users -->
<table>
    <thead>
        <tr>
            <th>Id</th>
            <th>Last Name</th>
            <th>First Name</th>
            <th>Mail</th>
            <th>Manage</th>
            <th>Delete</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($users as $user) : ?>
            <tr>
                <td><?= $user['user_id'] ?></td>
                <td><?= $user['first_name'] ?></td>
                <td><?= $user['last_name'] ?></td>
                <td><?= $user['mail'] ?></td>
                <td>
                    <a href="<?= url('/admin/users?id=' . $user['user_id']) ?>">Gérer</a>
                </td>
                <td>
                    <form action="<?= url('/delete-user') ?>">
                        <input type="hidden" name="user_id" value="<?= $user['user_id'] ?>">
                        <input type="submit" value="Supprimer" />
                    </form>
                </td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>

<?php
require_view('view/footer.php');
?>