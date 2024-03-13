<?php


class StaticController
{
    #[Route('/')]
    public function showHome()
    {
        require_view('view/home.php');
    }
}
