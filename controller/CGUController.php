<?php

class CGUController
{
    #[Route('/cgu')]
    public function cgu_show()
    {
        require_once 'model/db-cgu.php';
        $cgu = get_cgu();
        $GLOBALS['cgu'] = $cgu;
        require_view('view/cgu.php');
    }

    #[Route('/admin/cgu')]
    public function admin_cgu()
    {
        if (!is_admin_logged()) {
            return JSONResponse('error', 'Vous devez être connecté pour accéder à cette page.');
        }

        require_once 'model/db-cgu.php';
        $cgu = get_cgu();
        $GLOBALS['cgu'] = $cgu;
        require_view('view/admin/cgu_manage.php');
    }

    #[Route('/cgu/add')]
    #[Method('POST')]
    public function post_cgu_add()
    {
        if (!is_admin_logged()) {
            return JSONResponse('error', 'Vous devez être connecté pour accéder à cette page.');
        }

        $title = htmlspecialchars($_POST['title']);
        $content = htmlspecialchars($_POST['content']);

        require_once 'model/db-cgu.php';
        $success = add_cgu($title, $content);

        if ($success) {
            return JSONResponse('success', 'CGU ajoutée avec succès.');
        } else {
            return JSONResponse('error', 'Erreur lors de l\'ajout de la CGU.');
        }
    }

    #[Route('/cgu/update')]
    #[Method('POST')]
    public function post_cgu_update()
    {
        if (!is_admin_logged()) {
            return JSONResponse('error', 'Vous devez être connecté pour accéder à cette page.');
        }

        $cgu_id = intval($_POST['cgu_id']);
        $title = htmlspecialchars($_POST['title']);
        $content = htmlspecialchars($_POST['content']);

        require_once 'model/db-cgu.php';
        $success = update_cgu($cgu_id, $title, $content);

        if ($success) {
            return JSONResponse('success', 'CGU modifiée avec succès.');
        } else {
            return JSONResponse('error', 'Erreur lors de la modification de la CGU.');
        }
    }

    #[Route('/cgu/delete')]
    #[Method('POST')]
    public function post_cgu_delete()
    {
        if (!is_admin_logged()) {
            return JSONResponse('error', 'Vous devez être connecté pour accéder à cette page.');
        }

        $cgu_id = intval($_POST['cgu_id']);
        require_once 'model/db-cgu.php';
        $success = delete_cgu($cgu_id);

        if ($success) {
            return JSONResponse('success', 'CGU supprimée avec succès.');
        } else {
            return JSONResponse('error', 'Erreur lors de la suppression de la CGU.');
        }
    }
}
