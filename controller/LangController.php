<?php

class LangController
{
    #[Route('/set-lang-fr')]
    public function set_lang_fr()
    {
        setcookie('lang', 'fr', time() + 60 * 60 * 24 * 30, '/');
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }

    #[Route('/set-lang-en')]
    public function set_lang_en()
    {
        setcookie('lang', 'en', time() + 60 * 60 * 24 * 30, '/');
        // redirect to referer
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }
}
