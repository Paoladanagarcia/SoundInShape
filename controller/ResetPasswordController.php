<?php


class ResetPasswordController
{
    #[Route('/reset-password-mail')]
    public function display_reset_password_mail_form()
    {
        require_view('view/user/reset-password-mail.php');
    }

    #[Route('/post-reset-password-mail')]
    #[Method('POST')]
    public function create_reset_token()
    {
        # Called by POST /post-reset-password-mail
        $message = '';
        $message .= 'create_reset_token. ';

        if (!isset($_POST['mail']) || !filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)) {
            return JSONResponse('error', 'No mail provided or invalid mail.');
        }
        $mail = $_POST['mail'];
        $message .= 'Mail provided: ' . $mail . '. ';

        $token = hash('sha256', uniqid(rand(), true));

        require_once 'model/db-user.php';  // update_token_if_mail_exists($mail, $token)

        if (!update_token_if_mail_exists($mail, $token)) {
            return JSONResponse('error', 'Token not created: ' . $token);
        }

        // Send mail
        $headers  = 'From: jamesdevnow@gmail.com' . "\r\n" .
            'MIME-Version: 1.0' . "\r\n" .
            'Content-type: text/html; charset=utf-8';
        $link = url("/reset-password?token={$token}");

        if (!mail($mail, 'Reset password', 'Click here to reset your password: ' . "\r\n" .
            '<a href="' . $link . '">' . $link . '</a>', $headers)) {
            return JSONResponse('error', 'Mail not sent to: ' . $mail);
        }

        return JSONResponse('success', 'Mail sent to: ' . $mail, url(''));
    }

    #[Route('/reset-password')]
    public function display_reset_password_form()
    {
        require_view('view/user/reset-password.php');
    }

    #[Route('/post-reset-password')]
    #[Method('POST')]
    public function reset_password(): bool
    {
        require_once 'controller/functions/validateFormData.php';
        require_once 'utils.php';

        list($data, $errors) = validateFormData($_POST, [
            'password1' => 'required|' . FORM_RULES['password'],
            'password2' => 'required|' . FORM_RULES['password'],
            'token'     => 'required|' . FORM_RULES['token'],
        ]);

        if (!empty($errors)) {
            return JSONResponse('errors', $errors);
            return false;
        }

        if ($data['password1'] !== $data['password2']) {
            return JSONResponse('errors', 'Passwords do not match.');
        }

        require_once 'model/db-user.php';

        if (update_password_if_token_exists($data['token'], $data['password1'])) {
            return JSONResponse('success', 'Password updated.', url(''));
        } else {
            return JSONResponse('errors', 'Token not found.');
        }
    }
}
