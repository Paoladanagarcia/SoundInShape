<?php


class SessionController
{
    #[Route('/sessions')]
    public function sessions()
    {
        require_once 'model/db-session.php';
        require_once 'model/db-club.php';
        $GLOBALS['sessions'] = get_sessions();
        $GLOBALS['clubs'] = get_all_clubs();
        require_view('view/list-sessions.php');
    }

    #[Route('/session-suggestion')]
    public function sessionSuggestion()
    {
        echo 'Suggestion de session';
    }

    #[Route('/admin/sessions')]
    public function admin_view_sessions()
    {
        require_once 'controller/functions/session.php';
        if (!is_admin_logged()) {
            echo 'Vous devez être connecté en tant qu\'administrateur pour accéder à cette page.';
            return;
        }

        if (isset($_GET['session_id'])) {
            $session_id = intval($_GET['session_id']);
            $this->admin_manage_session($session_id);
            return;
        }

        require_once 'model/db-session.php';
        $GLOBALS['sessions'] = get_sessions();
        require_view('view/admin/sessions_view.php');
        unset($GLOBALS['sessions']);
    }

    #[Route('/admin/session/add')]
    public function admin_add_session()
    {
        require_once 'controller/functions/session.php';
        if (!is_admin_logged()) {
            echo 'Vous devez être connecté en tant qu\'administrateur pour accéder à cette page.';
            return;
        }

        require_view('view/admin/session_add.php');
    }

    public function admin_manage_session(int $session_id)
    {
        require_once 'controller/functions/session.php';
        if (!is_admin_logged()) {
            echo 'Vous devez être connecté en tant qu\'administrateur pour accéder à cette page.';
            return;
        }

        require_once 'model/db-session.php';
        $GLOBALS['session'] = get_session($session_id);
        require_view('view/admin/session_manage.php');
        unset($GLOBALS['session']);
    }

    #[Route('/post-manage-session')]
    #[Method('POST')]
    public function admin_post_manage_session()
    {
        require_once 'controller/functions/session.php';
        if (!is_admin_logged()) {
            echo 'Vous devez être connecté en tant qu\'administrateur pour accéder à cette page.';
            return;
        }

        require_once 'controller/functions/validateFormData.php';
        $session_id = intval($_POST['session_id']);
        unset($_POST['session_id']);

        // No validation
        $start_hour = htmlspecialchars($_POST['start_hour']);
        $end_hour = htmlspecialchars($_POST['end_hour']);
        $voted_noise_level = (int)htmlspecialchars($_POST['voted_noise_level']);
        $time_noise_level_approved = htmlspecialchars($_POST['time_noise_level_approved']);
        $club_id = (int)htmlspecialchars($_POST['club_id']);

        require_once 'model/db-session.php';
        if (!update_session(
            $session_id,
            $start_hour,
            $end_hour,
            $voted_noise_level,
            $time_noise_level_approved,
            $club_id
        )) {
            return JSONResponse('error', 'Erreur lors de la mise à jour de la session.');
        } else {
            return JSONResponse('success', 'Session mise à jour avec succès.', url('/admin/sessions'));
        }
    }

    #[Route('/post-add-session')]
    #[Method('POST')]
    public function post_add_session()
    {
        require_once 'controller/functions/session.php';
        if (!is_admin_logged()) {
            echo 'Vous devez être connecté en tant qu\'administrateur pour accéder à cette page.';
            return;
        }

        require_once 'controller/functions/validateFormData.php';
        $start_hour = htmlspecialchars($_POST['start_hour']);
        $end_hour = htmlspecialchars($_POST['end_hour']);
        $voted_noise_level = '';
        $time_noise_level_approved = '';
        $club_id = intval($_POST['club_id']);

        require_once 'model/db-session.php';
        if (!add_session(
            $start_hour,
            $end_hour,
            $voted_noise_level,
            $time_noise_level_approved,
            $club_id
        )) {
            return JSONResponse('error', 'Erreur lors de la création de la session.');
        } else {
            return JSONResponse('success', 'Session créée avec succès.', url('/admin/sessions'));
        }
    }

    #[Route('/delete-session')]
    #[Method('POST')]
    public function admin_delete_session()
    {
        require_once 'controller/functions/session.php';
        if (!is_admin_logged()) {
            return JSONResponse('error', 'Vous devez être connecté en tant qu\'administrateur pour accéder à cette page.');
        }

        require_once 'controller/functions/validateFormData.php';
        $session_id = intval($_POST['session_id']);

        require_once 'model/db-session.php';
        if (!session_exists($session_id)) {
            return JSONResponse('error', 'La session n\'existe pas.');
        }

        if (!delete_session($session_id)) {
            return JSONResponse('error', 'Erreur lors de la suppression de la session.');
        } else {
            return JSONResponse('success', 'Session supprimée avec succès.', url('/admin/sessions'));
        }
    }
}
