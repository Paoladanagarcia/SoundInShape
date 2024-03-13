<?php
global $unconfirmed_users;
global $unconfirmed_topics;
global $stats;

$GLOBALS['PAGE_TITLE'] = 'Admin Dashboard';
addCSS('dashboard.css');
require_view('view/header.php');
?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<h1>Admin Dashboard</h1>

<section id="to_confirm">
    <h2>Information to Confirm</h2>

    <?php if (count($unconfirmed_users) > 0) : ?>
        <div class="flex-container">
            <div>
                <h4>Users</h4>
                <table>
                    <thead>
                        <tr>
                            <th>Last Name</th>
                            <th>First Name</th>
                            <th>Mail</th>
                            <th>Register Date</th>
                            <th>Confirm</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($unconfirmed_users as $user) : ?>
                            <tr>
                                <td><?= $user['last_name'] ?></td>
                                <td><?= $user['first_name'] ?></td>
                                <td><?= $user['mail'] ?></td>
                                <td><?= $user['register_date'] ?></td>
                                <td>
                                    <form action="confirm-user" method="POST">
                                        <input type="hidden" name="user_id" value="<?= $user['user_id'] ?>">
                                        <input type="submit" value="Confirm">
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
        <?php if (count($unconfirmed_topics) > 0) : ?>
            <div>
                <h4>Forum Topics</h4>
                <table>
                    <thead>
                        <tr>
                            <th>Topic</th>
                            <th>Created By</th>
                            <th>Create Date</th>
                            <th>Confirm</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($unconfirmed_topics as $topic) : ?>
                            <tr>
                                <td><?= $topic['topic'] ?></td>
                                <td><?= $topic['user_id'] ?></td>
                                <td><?= $topic['create_date'] ?></td>
                                <td>
                                    <form action="approve-topic" method="POST">
                                        <input type="hidden" name="topic_id" value="<?= $topic['topic_id'] ?>">
                                        <input type="submit" value="Confirm">
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endif; ?>
</section>

<section id="main" class="flex-container">
    <aside>
        <h2>Manage the infrastructure</h2>
        <p><a href="<?= url('/admin/users') ?>">Users</a></p>
        <p><a href="<?= url('/admin/forum-topics') ?>">Forum</a></p>
        <p><a href="<?= url('/admin/clubs') ?>">Clubs</a></p>
        <p><a href="<?= url('/admin/sessions') ?>">Sessions</a></p>
        <p><a href="<?= url('/admin/sensors') ?>">Sensors</a></p>
        <p><a href="<?= url('/admin/faq') ?>">FAQ</a></p>
        <p><a href="<?= url('/admin/cgu') ?>">CGU</a></p>
        <p><a href="<?= url('/admin/legal') ?>">Legal Information</a></p>
    </aside>

    <div>
        <h2>Visualize some statistics</h2>

        <div id="grid-stats">
            <div><canvas class="stats" id="statsChart1"></canvas></div>
            <div><canvas class="stats" id="statsChart2"></canvas></div>
            <div><canvas class="stats" id="statsChart3"></canvas></div>
            <div><canvas class="stats" id="statsChart4"></canvas></div>
        </div>
    </div>
</section>

<script src="view/js/chartsdata.js"></script>

<?php
require_view('view/footer.php');
?>