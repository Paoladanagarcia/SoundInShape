<?php
$GLOBALS['PAGE_TITLE'] = 'Search';
addCSS('search.css');
$GLOBALS['NO_AJAX'] = true;
require_view('view/header.php');
?>

<h1>Multi Criteria Search</h1>

<div class="form-container">
    <h2>Search!</h2>
    <form action="<?= url('/searchresult') ?>" method="post">
        <div>
            <label for="titre">Title</label>
            <input type="text" id="titre" name="titre">
        </div>
        <div>
            <label for="auteur">Author</label>
            <input type="text" id="auteur" name="auteur">
        </div>
        <div>
            <label for="annee">Year</label>
            <input type="text" id="annee" name="annee">
        </div>
        <div>
            <label for="genre">Genre</label><br>
            <select name="genre" id="genre" style="width :100%">
                <option value="">Select...</option>
                <option value="Hip-hop">Hip-hop</option>
                <option value="Pop">Pop</option>
                <option value="Rock">Rock</option>
                <option value="Musique électronique">Electronic Music</option>
                <option value="J-pop">J-pop</option>
                <option value="Soundtrack">Soundtrack</option>
            </select>
        </div>
        <label for="go"></label>
        <input id="go" type="submit" value="Go!" class="BigButton btn">
    </form>
</div>

<?php
require_view('view/footer.php');
?>