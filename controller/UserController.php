<?php

class UserController
{
    // ----- GET -----
    public function get_user()
    {
        require_once 'model/db-user.php';

        // $users = get_all_users();

        require_view('view/user/get-user.php');
    }

    #[Route('/register')]
    public function display_register_user_form()
    {
        if (!is_the_session_started()) {


            // $GLOBALS['captcha_image'] = $this->generate_register_captcha();
            require_view('view/user/register.php');
        } else {
            header('Location: ' . url(''));
            return;
        }
    }

    #[Route('/register-captcha')]
    public function generate_register_captcha()
    {
        // CAPTCHA
        // Five random alphanumeric characters in a string separated by spaces
        $captcha_str = '';
        for ($i = 0; $i < 5; $i++) {
            $captcha_str .= chr(rand(97, 122));
            if ($i < 4) {
                $captcha_str .= ' ';
            }
        }

        setcookie('captcha_str', $captcha_str, time() + 3600, '/', "", false, true);
        $image = imagecreatetruecolor(200, 50);
        $textColor = imagecolorallocate($image, 255, 100, 0);

        // Get image dimensions
        $imageWidth = imagesx($image);
        $imageHeight = imagesy($image);

        // Get font width and height
        $fontWidth = imagefontwidth(5);
        $fontHeight = imagefontheight(5);

        // Calculate text width and height
        $textWidth = $fontWidth * strlen($captcha_str);
        $textHeight = $fontHeight;

        // Calculate positions
        $positionX = round(($imageWidth - $textWidth) / 2);
        $positionY = round(($imageHeight - $textHeight) / 2);

        imagestring($image, 5, $positionX, $positionY, $captcha_str, $textColor);
        ob_start();
        imagepng($image);
        $captcha_image = ob_get_clean();
        imagedestroy($image);

        echo base64_encode($captcha_image);
    }

    #[Route('/login')]
    public function display_login_form()
    {
        if (!is_the_session_started()) {
            require_view('view/user/login.php');
        } else {
            header('Location: ' . url(''));
            return;
        }
    }

    #[Route('/logout')]
    public function logout_user()
    {
        end_the_session();
        header('Location: ' . url(''));
    }

    #[Route('/my-sound-profile')]
    public function display_sound_profile()
    {
        require_once 'controller/functions/session.php';
        if (!is_the_session_started()) {
            echo "Vous devez être connecté pour voir votre niveau sonore préféré, et bénéficier d'une suggestion d'horaires !";
            return;
        }

        // Include view with session data
        require_once 'model/db-session.php';
        $session_suggestion_id = $this->calculate_session_suggestion($_SESSION['user_id']);
        $GLOBALS['suggested_session'] = get_session($session_suggestion_id);
        $GLOBALS['user_pref_noise'] = (float)prefNoiseLevel($_SESSION['user_id']);
        require_view('view/my-sound-profile.php');
    }

    #[Route('/verify-mail')]
    public function verify_mail()
    {
        $verify_mail_token = empty($_GET['verify_mail_token']) ? '' : $_GET['verify_mail_token'];
        $user_mail = empty($_GET['mail']) ? '' : $_GET['mail'];

        require_once 'model/db-user.php';
        $registered_verify_mail_token = get_token_by_mail($user_mail);
        if ($registered_verify_mail_token === $verify_mail_token) {
            if (update_verify_mail_token($user_mail, '')) {
                if (set_mail_confirmed($user_mail)) {
                    $message = 'Mail confirmed: ' . $user_mail . ' -#- ';
                    return JSONResponse('success', $message, url(''));
                } else {
                    $message = 'Error while confirming mail: ' . $user_mail . ' -#- ';
                    return JSONResponse('error', $message);
                }
            } else {
                $message = 'Couldnt update verify mail to null: ' . $user_mail . ' -#- ';
                return JSONResponse('error', $message);
            }
        } else {
            $message = 'Wrong token: ' . $verify_mail_token . ' -#- ';
            return JSONResponse('error', $message);
        }
    }

    #[Route('/get-session-suggestion')]
    public function get_session_suggestion()
    {
        require_once 'controller/functions/session.php';
        if (!is_the_session_started()) {
            return JSONResponse('error', 'Vous devez être connecté pour voir votre niveau sonore préféré, et bénéficier d\'une suggestion d\'horaires !');
        }

        $session_suggestion_id = $this->calculate_session_suggestion($_SESSION['user_id']);
        require_once 'model/db-session.php';
        $suggested_session = get_session($session_suggestion_id);
        echo $suggested_session['start_hour'] . " - " . $suggested_session['end_hour'];
    }

    private function calculate_session_suggestion($user_id)
    {
        require_once 'model/db-user.php';
        $moyennes_sessions = calculateAverageNoise();
        $user_pref_noise = (float)prefNoiseLevel($user_id);

        $closest_session_id = null;
        $min_difference = PHP_INT_MAX;

        foreach ($moyennes_sessions as $moyenne_session) {
            $current_session_avg_level = (float)$moyenne_session['average_noise'];
            $current_session_id = (float)$moyenne_session['session_id'];

            // Calculer la différence absolue entre les niveaux de l'utilisateur et de la session
            $difference = abs($user_pref_noise - $current_session_avg_level);

            // Mettre à jour la session la plus proche si la différence actuelle est plus petite
            if ($difference < $min_difference) {
                $min_difference = $difference;
                $closest_session_id = $current_session_id;
            }
        }

        return $closest_session_id;
    }


    // ----- POST -----
    #[Route('/post-register-user')]
    #[Method('POST')]
    public function post_register_user()
    {
        header('Content-Type: application/json');

        // Check captcha
        if (!isset($_POST['user_captcha'])) {
            return JSONResponse('error', 'Captcha not set.');
        }

        // Compared both value after removing spaces
        $user_captcha = str_replace(' ', '', $_POST['user_captcha']);
        // Very important
        unset($_POST['user_captcha']);
        $captcha_str = str_replace(' ', '', $_COOKIE['captcha_str']);
        if ($user_captcha !== $captcha_str) {
            return JSONResponse('error', 'Wrong captcha.');
        }

        require_once 'controller/functions/validateFormData.php';
        list($form_data, $error_message) = validateFormData($_POST, [
            'last_name'     => 'required|' . FORM_RULES['name'],
            'first_name'    => 'required|' . FORM_RULES['name'],
            'birthdate'     => 'required|' . FORM_RULES['date'],
            'address'       => 'required|' . FORM_RULES['address'],
            'city'          => 'required|' . FORM_RULES['city'],
            'postal_code'   => 'required|' . FORM_RULES['postal_code'],
            'mail'          => 'required|' . FORM_RULES['mail'],
            'password1'     => 'required|' . FORM_RULES['password'],
            'password2'     => 'required|' . FORM_RULES['password'],
        ]);

        if ($error_message !== '') {
            return JSONResponse('error', $error_message);
            return false;
        }

        if ($form_data['password1'] !== $form_data['password2']) {
            return JSONResponse('error', 'Passwords do not match.');
            return false;
        }

        require_once 'model/db-user.php';
        if (get_id_by_mail($form_data['mail'])) {
            return JSONResponse('error', 'Mail already used.');
            return false;
        }

        $form_data['password_hash'] = password_hash($form_data['password1'], PASSWORD_DEFAULT);
        unset($form_data['password1']);
        unset($form_data['password2']);

        if (!post_user($form_data)) {
            return JSONResponse('error', 'Error while saving user');
        }
        // return JSONResponse('success', 'User created', url(''));
        $verify_mail_token = hash('sha256', uniqid(rand(), true));

        require_once 'model/db-user.php';
        $user_mail = $form_data['mail'];
        if (!update_verify_mail_token($user_mail, $verify_mail_token)) {
            return JSONResponse('error', 'Couldnt update_verify_mail_token with: ' . $user_mail);
        }

        // Send mail confirmation to verify the mail address
        $headers  = 'From: jamesdevnow@gmail.com' . "\r\n" .
            'MIME-Version: 1.0' . "\r\n" .
            'Content-type: text/html; charset=utf-8';
        $link = url("/verify-mail?verify_mail_token={$verify_mail_token}&mail={$user_mail}");

        if (!mail($user_mail, 'Verify your mail', 'Click here to verify your mail: ' . "\r\n" .
            '<a href="' . $link . '">' . $link . '</a>', $headers)) {
            return JSONResponse('error', 'Mail not sent to: ' . $user_mail);
        }

        return JSONResponse('success', 'Mail sent to: ' . $user_mail, url(''));
    }

    #[Route('/post-login')]
    #[Method('POST')]
    public function post_login()
    {
        // $mail and $password

        $erreur = '';

        if (isset($_POST['mail'])) {
            $mail = htmlspecialchars($_POST['mail']);
        } else {
            $erreur .= 'Il faut renseigner un mail ';
        }

        if (isset($_POST['password'])) {
            $password = $_POST['password'];
        } else {
            $erreur .= 'Il faut renseigner un mot de passe ';
        }

        if ($erreur != '') {
            return JSONResponse('error', $erreur);
        }

        // Verify the password
        require_once 'model/db-user.php';

        if (!get_id_by_mail($mail)) {
            return JSONResponse('error', 'Wrong mail or password.');
        }

        $registered_user_hash = get_hash_by_mail($mail);

        if (!password_verify($password, $registered_user_hash)) {
            return JSONResponse('error', 'Wrong mail or password.');
        }

        $user_id = get_id_by_mail($mail);
        if (!is_mail_confirmed($user_id)) {
            return JSONResponse('error', 'Your mail is not confirmed yet.');
        } else {
            $_SESSION['user_id'] = $user_id;
            return JSONResponse('success', 'You are now logged in.', url(''));
        }
    }

    #[Route('/edit-profile')]
    public function edit_user()
    {
        # Session must be started
        require_once 'controller/functions/session.php';

        if (!is_the_session_started()) {
            exit;
        }

        require_once 'model/db-user.php';

        $show_private_fields = is_admin_by_id($_SESSION['user_id']);
        $user_attr = get_user($_SESSION['user_id']);

        $GLOBALS['show_private_fields'] = $show_private_fields;
        $GLOBALS['user_attr'] = $user_attr;

        require_view('view/user/edit-profile.php');

        unset($GLOBALS['show_private_fields']);
        unset($GLOBALS['user_attr']);
    }

    #[Route('/post-edit-profile')]
    #[Method('POST')]
    public function post_edit_user()
    {
        // Response will be in JSON
        header('Content-Type: application/json');

        require_once 'controller/functions/validateFormData.php';
        // var_dump($_POST);
        list($form_data, $error_message) = validateFormData($_POST, [
            'last_name'     => 'optional|' . FORM_RULES['name'],
            'first_name'    => 'optional|' . FORM_RULES['name'],
            'birthdate'     => 'optional|' . FORM_RULES['date'],
            'address'       => 'optional',
            'city'          => 'optional',
            'postal_code'   => 'optional',
            'mail'          => 'optional|' . FORM_RULES['mail'],
        ]);

        if ($error_message !== '') {
            return JSONResponse('error', $error_message);
        }

        require_once 'model/db-user.php';
        if (partial_update_fields_by_id($_SESSION['user_id'], $form_data)) {
            return JSONResponse('success', 'User updated');
        } else {
            return JSONResponse('error', 'Error while saving user');
        }
    }

    #[Route('/confirm-user')]
    #[Method('POST')]
    public function confirm_user()
    {
        header('Content-Type: application/json');

        $response = [
            'status' => 'error',
            'message' => '',
            'redirect_to' => ''
        ];

        require_once 'controller/functions/session.php';
        if (!is_admin_logged()) {
            $response['message'] .= 'Vous devez être connecté en tant qu\'administrateur pour confirmer un utilisateur. ';
            echo json_encode($response);
            return false;
        }

        if (empty($_POST['user_id'])) {
            $response['message'] .= 'Merci d\'indiquer un utilisateur. ';
            echo json_encode($response);
            return false;
        }

        $user_id = intval($_POST['user_id']);
        require_once 'model/db-user.php';
        $confirm_result = confirm_user($user_id, $_SESSION['user_id']);
        if ($confirm_result === false) {
            $response['message'] .= 'Erreur lors de la confirmation de l\'utilisateur. ';
            echo json_encode($response);
            return false;
        }

        $response['status'] = 'success';
        $response['message'] .= 'Utilisateur confirmé avec succès. ';
        $response['redirect_to'] = 'admin';
        echo json_encode($response);
        return true;
    }

    #[Route('/delete-user')]
    #[Method('POST')]
    public function delete_user(): bool
    {
        header('Content-Type: application/json');

        $user_id = (int)$_POST['user_id'];
        $response = [
            'status' => 'error',
            'message' => '',
            'redirect_to' => ''
        ];

        // Access by this user or an admin
        require_once 'controller/functions/session.php';
        if (!is_admin_logged() || (is_regular_user_logged() && $_SESSION['user_id'] != $user_id)) {
            $response['message'] .= 'Vous n\'avez pas les droits pour supprimer cet utilisateur. ';
            echo json_encode($response);
            return false;
        }

        require_once 'model/db-user.php';
        if (!delete_user_by_id($user_id)) {
            $response['message'] .= 'Erreur lors de la suppression de l\'utilisateur. ';
            echo json_encode($response);
            return false;
        }

        // Logout if the user deleted himself
        if ($_SESSION['user_id'] == $user_id) {
            end_the_session();
        }

        $response['status'] = 'success';
        $response['message'] .= 'Utilisateur supprimé avec succès. ';
        $response['redirect_to'] = url('/admin/users');
        echo json_encode($response);
        return true;
    }

    #[Route('/post-manage-user')]
    #[Method('POST')]
    public function post_manage_user(): bool
    {
        // Access by an admin
        require_once 'controller/functions/session.php';
        if (!is_admin_logged()) {
            return JSONResponse('error', 'Vous n\'avez pas les droits pour modifier cet utilisateur.');
        }

        require_once 'controller/functions/validateFormData.php';


        list($form_data, $error_message) = validateFormData($_POST, [
            'user_id'                   => 'required|' . FORM_RULES['id'],
            'last_name'                 => 'optional|' . FORM_RULES['name'],
            'first_name'                => 'optional|' . FORM_RULES['name'],
            'birthdate'                 => 'optional|' . FORM_RULES['date'],
            'address'                   => 'optional|' . FORM_RULES['address'],
            'city'                      => 'optional|' . FORM_RULES['city'],
            'postal_code'               => 'optional|' . FORM_RULES['postal_code'],
            'mail'                      => 'optional|' . FORM_RULES['mail'],
            'register_date'             => 'optional|' . FORM_RULES['date'],
            'password_recovery_token'   => 'optional|' . FORM_RULES['token'],
            'registration_approved'     => 'optional|' . FORM_RULES['checkbox'],
            'admin_approving'           => 'optional|' . FORM_RULES['id'],
            'club_id'                   => 'optional|' . FORM_RULES['id'],
        ]);

        $user_id = intval($form_data['user_id']);
        unset($form_data['user_id']);

        if ($error_message !== '') {
            return JSONResponse('error', $error_message);
        }

        require_once 'model/db-user.php';
        if (!partial_update_fields_by_id($user_id, $form_data)) {
            return JSONResponse('error', 'No update');
        }

        require_once 'config.php';
        return JSONResponse('success', 'User updated');
    }

    #[Route('/post-update-user-pref-noise')]
    #[Method('POST')]
    public function post_update_pref_noise()
    {
        require_once 'controller/functions/session.php';
        if (!is_the_session_started()) {
            return JSONResponse('error', 'Vous devez être connecté pour modifier votre niveau sonore préféré.');
        }

        $modifier = (int)$_POST['pref_noise_modifier'];
        require_once 'model/db-user.php';
        $pref_noise = (int)prefNoiseLevel($_SESSION['user_id']);
        $pref_noise += $modifier;
        if ($pref_noise < 30 || $pref_noise > 90) {
            return JSONResponse('error', 'Le niveau sonore préféré doit être compris entre 30 et 90.');
        }

        if (!update_pref_noise($_SESSION['user_id'], $pref_noise)) {
            return JSONResponse('error', 'Erreur lors de la mise à jour du niveau sonore préféré.');
        }

        return JSONResponse('success', 'Niveau sonore préféré mis à jour.');
    }
}
