<?php

class AdminDashBoardController
{
    public function __construct()
    {
        // Anyone trying to instantiate this class must be an admin
        require_once 'controller/functions/session.php';
        if (!is_admin_logged()) {
            echo 'You are not an admin!';
            exit;
        }
    }

    #[Route('/admin')]
    public function index(): void
    {
        // Fetch unconfirmed user registrations
        require_once 'model/db-user.php';
        $unconfirmed_users = get_unconfirmed_users();
        // Only keep the user_id, last_name, first_name, mail and registration_date
        $unconfirmed_users = array_map(function ($user) {
            return array(
                'user_id' => $user['user_id'],
                'last_name' => $user['last_name'],
                'first_name' => $user['first_name'],
                'mail' => $user['mail'],
                'register_date' => $user['register_date']
            );
        }, $unconfirmed_users);

        // Fetch unconfirmed forum topics
        require_once 'model/db-forum.php';
        $unconfirmed_topics = get_unconfirmed_topics();
        // Only keep the topic_id, topic, user_id and creation_date
        $unconfirmed_topics = array_map(function ($topic) {
            return array(
                'topic_id' => $topic['forum_topic_id'],
                'topic' => $topic['topic'],
                'user_id' => $topic['user_id'],
                'create_date' => $topic['create_date']
            );
        }, $unconfirmed_topics);


        // ------------------------------
        $GLOBALS['unconfirmed_users'] = $unconfirmed_users;
        $GLOBALS['unconfirmed_topics'] = $unconfirmed_topics;
        require_view('view/admin/dashboard.php');
        unset($GLOBALS['unconfirmed_users']);
        unset($GLOBALS['unconfirmed_topics']);
        // ------------------------------
    }

    #[Route('/admin/users')]
    public function manage_users()
    {
        if (!empty($_GET['id'])) {
            $this->manager_user($_GET['id']);
            return;
        }

        require_once 'model/db-user.php';
        $users = get_all_users();

        $GLOBALS['users'] = $users;
        require_view('view/admin/users_view.php');
        unset($GLOBALS['users']);
    }

    public function manager_user(int $user_id)
    {
        require_once 'model/db-user.php';
        $user = get_user($user_id);
        if (!$user) {
            echo "<p>L'utilisateur $user_id n'existe pas!</p>";
            return;
        }

        $GLOBALS['user'] = $user;
        require_view('view/admin/user_manage.php');
        unset($GLOBALS['user']);
    }

    public function get_stats(): array
    {
        $contents = file_get_contents(url('/stats/get'));
        $stats = json_decode($contents, associative: true);
        // var_dump($stats);
        return $stats;
    }
}
