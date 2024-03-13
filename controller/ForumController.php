<?php

class ForumController
{
    #[Route('/forum')]
    public function index()
    {
        # Check for requested topic
        if (!empty($_GET['topic'])) {
            $topic_id = intval($_GET['topic']);
            require_once 'model/db-forum.php';
            if (!topic_exists($topic_id)) {
                require_view('view/404.php');
            } else {
                $this->get_topic($topic_id);
            }
            return;
        }

        # List the topics
        require_once 'model/db-forum.php';
        $forum_topics = get_all_confirmed_topics();
        $nb_messages = [];
        foreach ($forum_topics as $topic) {
            $nb_messages[$topic['forum_topic_id']] = get_nb_messages_for_topic($topic['forum_topic_id']);
        }

        $GLOBALS['forum_topics'] = $forum_topics;
        $GLOBALS['nb_messages'] = $nb_messages;
        require_view('view/forum/index.php');

        unset($GLOBALS['forum_topics']);
        unset($GLOBALS['nb_messages']);
    }

    public function get_topic($topic_id)
    {
        require_once 'model/db-forum.php';

        if (!is_topic_approved($topic_id)) {
            echo 'Ce sujet n\'a pas encore été approuvé.';
            return;
        }

        $topic = get_topic($topic_id);
        $forum_messages = get_all_messages_for_topic($topic_id);

        $GLOBALS['forum_topic'] = $topic;
        $GLOBALS['forum_messages'] = $forum_messages;
        require_view('view/forum/topic.php');
        unset($GLOBALS['forum_topic']);
        unset($GLOBALS['forum_messages']);
    }

    #[Route('/admin/forum-topics')]
    public function admin_view_topics()
    {
        if (!is_admin_logged()) {
            return JSONResponse('error', 'Vous devez être connecté en tant qu\'administrateur pour voir cette page. [admin_view_topics]');
        }

        if (!empty($_GET['id'])) {
            $topic_id = intval($_GET['id']);
            require_once 'model/db-forum.php';
            if (!topic_exists($topic_id)) {
                echo 'Ce sujet n\'existe pas.';
            } else {
                $this->admin_manage_topic($topic_id);
            }
            return;
        }

        require_once 'model/db-forum.php';
        $GLOBALS['topics'] = get_all_topics();
        require_view('view/admin/forum_topics_view.php');
        unset($GLOBALS['topics']);
    }

    public function admin_manage_topic($topic_id)
    {
        if (!is_admin_logged()) {
            return JSONResponse('error', 'Vous devez être connecté en tant qu\'administrateur pour voir cette page. [admin_manage_topic]');
        }

        require_once 'model/db-forum.php';
        if (!topic_exists($topic_id)) {
            echo 'Ce sujet n\'existe pas.';
            return;
        }

        $GLOBALS['topic'] = get_topic($topic_id);
        require_view('view/admin/forum_topic_manage.php');
        unset($GLOBALS['topic']);
    }

    #[Route('/admin/forum-messages')]
    public function admin_view_messages()
    {
        if (!is_admin_logged()) {
            return JSONResponse('error', 'Vous devez être connecté en tant qu\'administrateur pour voir cette page. [admin_view_messages]');
        }

        if (empty($_GET['topic_id'])) {
            echo 'Merci d\'indiquer un sujet.';
            return;
        }

        $topic_id = intval($_GET['topic_id']);
        require_once 'model/db-forum.php';
        if (!topic_exists($topic_id)) {
            echo 'Ce sujet n\'existe pas.';
            return;
        }

        $GLOBALS['topic'] = get_topic($topic_id);
        $GLOBALS['messages'] = get_all_messages_for_topic($topic_id);
        require_view('view/admin/forum_messages_view.php');
        unset($GLOBALS['topic']);
        unset($GLOBALS['messages']);
    }

    #[Route('/manage-forum-topic')]
    #[Method('POST')]
    public function admin_manage_topic_post()
    {
        if (!is_admin_logged()) {
            return JSONResponse('error', 'Vous devez être connecté en tant qu\'administrateur pour voir cette page. [admin_manage_topic_post]');
        }

        if (empty($_POST['topic_id'])) {
            return JSONResponse('error', 'Merci d\'indiquer un sujet.');
        }

        // Verify information sent by POST: forum_topic_id, topic, create_date, is_approved, admin_id, user_id
        require_once 'controller/functions/validateFormData.php';
        $topic_id = intval($_POST['topic_id']);
        unset($_POST['topic_id']);
        list($topic_data, $error) = validateFormData([
            'topic'             => $_POST['topic'],
            'create_date'       => $_POST['create_date'],
            'is_approved'       => $_POST['is_approved'],
            'admin_id'          => $_POST['admin_id'],
            'user_id'           => $_POST['user_id']
        ], [
            'topic'             => 'required',
            'create_date'       => 'required|datetime',
            'is_approved'       => 'optional|numeric',
            'admin_id'          => 'required|numeric',
            'user_id'           => 'required|numeric'
        ]);

        if ($error) {
            return JSONResponse('error', $error);
        }

        require_once 'model/db-forum.php';
        if (!update_topic($topic_id, $topic_data)) {
            return JSONResponse('error', 'Erreur lors de la mise à jour du sujet.');
        } else {
            return JSONResponse('success', 'Sujet mis à jour avec succès.', url('/admin/forum-topics'));
        }
    }

    #[Route('/post-forum-topic')]
    #[Method('POST')]
    public function post_forum_topic()
    {
        require_once 'controller/functions/session.php';
        if (!is_the_session_started()) {
            return JSONResponse('error', 'Vous devez être connecté pour créer un nouveau sujet.');
        }

        if (empty($_POST['topic'])) {
            return JSONResponse('error', 'Merci d\'indiquer un nom de sujet.');
        }

        $topic = htmlspecialchars($_POST['topic']);
        $user_id = $_SESSION['user_id'];
        require_once 'model/db-forum.php';
        $create_result = create_topic($topic, $user_id);
        if ($create_result === false) {
            return JSONResponse('error', 'Erreur lors de la création du sujet.');
        }

        if (is_admin_logged()) {
            return JSONResponse('success', 'Sujet créé avec succès.', url('/admin'));
        } else {
            return JSONResponse('success', 'Sujet créé avec succès.', url('/forum?topic=' . $create_result));
        }
    }

    #[Route('/post-forum-message')]
    #[Method('POST')]
    public function post_forum_message()
    {
        require_once 'controller/functions/session.php';
        require_once 'model/db-forum.php';

        if (is_regular_user_logged() && !is_topic_approved($_POST['topic_id'])) {
            require_view('view/404.php');
            return;
        }

        header('Content-Type: application/json');

        $response = [
            'status' => 'error',
            'message' => '',
            'redirect_to' => ''
        ];

        require_once 'controller/functions/session.php';
        if (!is_the_session_started()) {
            $response['message'] .= 'Vous devez être connecté pour poster un message. ';
            echo json_encode($response);
            return false;
        }

        if (empty($_POST['message'])) {
            $response['message'] .= 'Merci d\'écrire un message. ';
            echo json_encode($response);
            return false;
        }

        if (empty($_POST['topic_id'])) {
            $response['message'] .= 'Merci d\'indiquer un sujet. ';
            echo json_encode($response);
            return false;
        }

        $message = htmlspecialchars($_POST['message']);
        $user_id = $_SESSION['user_id'];
        $topic_id = intval($_POST['topic_id']);

        $create_result = create_message($message, $user_id, $topic_id);
        if ($create_result === false) {
            $response['message'] .= 'Erreur lors de la création du message. ';
            echo json_encode($response);
            return false;
        }

        $response['status'] = 'success';
        $response['message'] .= 'Message créé avec succès. ';
        $response['redirect_to'] = 'forum?topic=' . $topic_id;
        echo json_encode($response);
        return true;
    }

    #[Route('/approve-topic')]
    #[Method('POST')]
    public function approve_topic()
    {
        header('Content-Type: application/json');

        $response = [
            'status' => 'error',
            'message' => '',
            'redirect_to' => ''
        ];

        require_once 'controller/functions/session.php';
        if (!is_admin_logged()) {
            $response['message'] .= 'Vous devez être connecté en tant qu\'administrateur pour approuver un sujet. ';
            echo json_encode($response);
            return false;
        }

        if (empty($_POST['topic_id'])) {
            $response['message'] .= 'Merci d\'indiquer un sujet. ';
            echo json_encode($response);
            return false;
        }

        $topic_id = intval($_POST['topic_id']);
        require_once 'model/db-forum.php';
        $approve_result = approve_topic($topic_id, $_SESSION['user_id']);
        if ($approve_result === false) {
            $response['message'] .= 'Erreur lors de l\'approbation du sujet. ';
            echo json_encode($response);
            return false;
        }

        $response['status'] = 'success';
        $response['message'] .= 'Sujet approuvé avec succès. ';
        $response['redirect_to'] = 'admin';
        echo json_encode($response);
        return true;
    }

    #[Route('/delete-topic')]
    #[Method('POST')]
    public function delete_topic()
    {
        if (!is_admin_logged()) {
            return JSONResponse('error', 'Vous devez être connecté en tant qu\'administrateur pour supprimer un sujet.');
        }

        if (empty($_POST['topic_id'])) {
            return JSONResponse('error', 'Merci d\'indiquer un sujet.');
        }
        $topic_id = intval($_POST['topic_id']);

        require_once 'model/db-forum.php';
        if (!delete_topic($topic_id)) {
            return JSONResponse('error', 'Erreur lors de la suppression du sujet.');
        } else {
            return JSONResponse('success', 'Sujet supprimé avec succès.', url('/admin/forum-topics'));
        }
    }

    #[Route('/edit-message')]
    #[Method('POST')]
    public function admin_edit_message()
    {
        if (!is_admin_logged()) {
            return JSONResponse('error', 'Vous devez être connecté en tant qu\'administrateur pour modifier un message.');
        }

        if (empty($_POST['message_id'])) {
            return JSONResponse('error', 'Merci d\'indiquer un message.');
        }
        $message_id = intval($_POST['message_id']);

        if (empty($_POST['forum-message'])) {
            return JSONResponse('error', 'Merci d\'indiquer un message.');
        }
        $message = htmlspecialchars($_POST['forum-message']);

        require_once 'model/db-forum.php';
        if (!update_message($message_id, $message)) {
            return JSONResponse('error', 'Erreur lors de la mise à jour du message.');
        } else {
            return JSONResponse('success', 'Message mis à jour avec succès.', url('/admin/forum-messages?topic_id=' . $_POST['topic_id']));
        }
    }

    #[Route('/delete-message')]
    #[Method('POST')]
    public function admin_delete_message()
    {
        if (!is_admin_logged()) {
            return JSONResponse('error', 'Vous devez être connecté en tant qu\'administrateur pour supprimer un message.');
        }

        if (empty($_POST['message_id'])) {
            return JSONResponse('error', 'Merci d\'indiquer un message.');
        }
        $message_id = intval($_POST['message_id']);

        require_once 'model/db-forum.php';
        if (!delete_message($message_id)) {
            return JSONResponse('error', 'Erreur lors de la suppression du message.');
        } else {
            return JSONResponse('success', 'Message supprimé avec succès.', url('/admin/forum-messages?topic_id=' . $_POST['topic_id']));
        }
    }
}
