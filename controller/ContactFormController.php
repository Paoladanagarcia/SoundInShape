<?php


class ContactFormController
{
    #[Route('/contact-form')]
    public function contact_form()
    {
        require_view('view/contact-form/contact-form.php');
    }

    #[Route('/post-contact-form')]
    #[Method('POST')]
    public function post_contact_form()
    {
        if (empty($_POST['mail']) || empty($_POST['msg'])) {
            return JSONResponse('error', 'Veuillez remplir tous les champs');
        }

        $mail = htmlspecialchars($_POST['mail']);
        $msg = htmlspecialchars($_POST['msg']);
        $mail_msg = '<h1>Message de: ' . $mail . '</h1>';
        $mail_msg .= 'Message: ' . $msg;

        // Send mail
        $headers  = 'From: jamesdevnow@gmail.com' . "\r\n" .
            'MIME-Version: 1.0' . "\r\n" .
            'Content-type: text/html; charset=utf-8';
        if (mail('jamesdevnow@gmail.com', 'Message du site SoudInShape', $mail_msg, $headers)) {
            return JSONResponse('success', 'Mail sent to SoundInShape. Thank you!', url(''));
        } else {
            return JSONResponse('error', 'Mail NOT sent to: ' . $mail);
        }
    }
}
