<?php

class LegalController
{
    #[Route('/legal')]
    public function legal_show()
    {
        require_once 'model/db-legal.php';
        $legal = get_legal();
        foreach ($legal as &$elem) {
            $elem['content'] = str_replace("\n", '<br>', $elem['content']);
        }

        $GLOBALS['legal'] = $legal;
        require_view('view/legal.php');
    }

    #[Route('/admin/legal')]
    public function admin_legal()
    {
        if (!is_admin_logged()) {
            return JSONResponse('error', 'Vous devez être connecté pour accéder à cette page.');
        }

        require_once 'model/db-legal.php';
        $legal = get_legal();
        $GLOBALS['legal'] = $legal;
        require_view('view/admin/legal_manage.php');
    }

    #[Route('/legal/add')]
    #[Method('POST')]
    public function post_legal_add()
    {
        if (!is_admin_logged()) {
            return JSONResponse('error', 'Vous devez être connecté pour accéder à cette page.');
        }

        $title = htmlspecialchars($_POST['title']);
        $content = htmlspecialchars($_POST['content']);

        require_once 'model/db-legal.php';
        $success = add_legal($title, $content);

        if ($success) {
            return JSONResponse('success', 'legal ajoutée avec succès.');
        } else {
            return JSONResponse('error', 'Erreur lors de l\'ajout de la legal.');
        }
    }

    #[Route('/legal/update')]
    #[Method('POST')]
    public function post_legal_update()
    {
        if (!is_admin_logged()) {
            return JSONResponse('error', 'Vous devez être connecté pour accéder à cette page.');
        }

        $legal_id = intval($_POST['legal_id']);
        $title = htmlspecialchars($_POST['title']);
        $content = htmlspecialchars($_POST['content']);

        require_once 'model/db-legal.php';
        $success = update_legal($legal_id, $title, $content);

        if ($success) {
            return JSONResponse('success', 'legal modifiée avec succès.');
        } else {
            return JSONResponse('error', 'Erreur lors de la modification de la legal.');
        }
    }

    #[Route('/legal/delete')]
    #[Method('POST')]
    public function post_legal_delete()
    {
        if (!is_admin_logged()) {
            return JSONResponse('error', 'Vous devez être connecté pour accéder à cette page.');
        }

        $legal_id = intval($_POST['legal_id']);
        require_once 'model/db-legal.php';
        $success = delete_legal($legal_id);

        if ($success) {
            return JSONResponse('success', 'legal supprimée avec succès.');
        } else {
            return JSONResponse('error', 'Erreur lors de la suppression de la legal.');
        }
    }
}
