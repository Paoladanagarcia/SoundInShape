<?php


function start_the_session()
{
    ini_set('session.cookie_secure', true);
    ini_set('session.cookie_httponly', true);
    ini_set('session.use_only_cookies', true);
    ini_set('session.cookie_samesite', 'Strict');
    ini_set('session.cookie_lifetime', 0);
    ini_set('session.gc_maxlifetime', 3600);
    session_start();
    // session_regenerate_id(true);
}

function end_the_session()
{
    session_unset();
    session_destroy();
}

function is_the_session_started()
{
    if (
        session_status() !== PHP_SESSION_ACTIVE ||
        !isset($_SESSION['user_id'])
    ) {
        return false;
    }

    // Know is is_mail_confirmed is set to 1
    $user_id = intval($_SESSION['user_id']);
    require_once 'model/db-user.php';
    $user = get_user($user_id);

    if ($user['is_mail_confirmed'] != 1) {
        return false;
    }

    return true;
}

function is_admin_logged()
{
    require_once 'model/db-user.php';
    return is_the_session_started() && is_admin_by_id($_SESSION['user_id']);
}

function is_regular_user_logged()
{
    require_once 'model/db-user.php';
    return is_the_session_started() && !is_admin_by_id($_SESSION['user_id']);
}
