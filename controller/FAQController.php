<?php

class FAQController
{
    #[Route('/faq')]
    public function faq_show()
    {
        require_once 'model/db-faq.php';
        $faq = get_faq();
        $GLOBALS['faq'] = $faq;
        require_view('view/FAQ.php');
    }

    #[Route('/admin/faq')]
    public function admin_faq()
    {
        // Must be admin
        if (!is_admin_logged()) {
            return JSONResponse('error', 'You are not an admin!');
        }

        require_once 'model/db-faq.php';
        $faq = get_faq();

        $GLOBALS['faq'] = $faq;
        require_view('view/admin/faq_manage.php');
        unset($GLOBALS['faq']);
    }

    #[Route('/faq/add')]
    #[Method('POST')]
    public function post_faq_add()
    {
        // Must be admin
        if (!is_admin_logged()) {
            return JSONResponse('error', 'You are not an admin!');
        }

        $question = htmlspecialchars($_POST['question']);
        $answer = htmlspecialchars($_POST['answer']);

        require_once 'model/db-faq.php';
        if (!add_faq($question, $answer)) {
            return JSONResponse('error', 'Error while adding the FAQ');
        }

        return JSONResponse('success', 'FAQ added successfully');
    }

    #[Route('/faq/update')]
    #[Method('POST')]
    public function post_faq_update()
    {
        // Must be admin
        if (!is_admin_logged()) {
            return JSONResponse('error', 'You are not an admin!');
        }

        $faq_id = intval($_POST['faq_id']);
        $question = htmlspecialchars($_POST['question']);
        $answer = htmlspecialchars($_POST['answer']);

        require_once 'model/db-faq.php';
        if (!update_faq($faq_id, $question, $answer)) {
            return JSONResponse('error', 'Error while updating the FAQ');
        }

        return JSONResponse('success', 'FAQ updated successfully');
    }

    #[Route('/faq/delete')]
    #[Method('POST')]
    public function post_faq_delete()
    {
        // Must be admin
        if (!is_admin_logged()) {
            return JSONResponse('error', 'You are not an admin!');
        }

        $faq_id = intval($_POST['faq_id']);

        require_once 'model/db-faq.php';
        if (!delete_faq($faq_id)) {
            return JSONResponse('error', 'Error while deleting the FAQ');
        }

        return JSONResponse('success', 'FAQ deleted successfully');
    }
}
