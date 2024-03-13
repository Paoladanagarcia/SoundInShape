<?php

class SearchController
{
    #[Route('/search')]
    public function show_search()
    {
        require_view('view/search/search.php');
    }

    #[Route('/searchresult')]
    #[Method('POST')]
    public function show_searchresult()
    {
        require_once 'model/db-search.php';
        $GLOBALS['search'] = search();
        require_view('view/search/searchresult.php');
    }
}
