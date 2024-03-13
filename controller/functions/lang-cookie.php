<?php

if (!isset($_COOKIE['lang'])) {
    // One month
    setcookie('lang', 'fr', time() + 60 * 60 * 24 * 30, '/');
    // Accelerate cookie availability
    $_COOKIE['lang'] = 'fr';
}
