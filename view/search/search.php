<?php
$GLOBALS['PAGE_TITLE'] = 'Recherche';
addCSS('search.css');
$GLOBALS['NO_AJAX'] = true;
require_view('view/header.php');
?>

<h1>Recherche multi-critères</h1>

<div class="form-container">
    <h2>Rechercher!</h2>
    <form action="<?= url('/searchresult') ?>" method="post">
        <div>
            <label for="titre">Titre</label>
            <input type="text" id="titre" name="titre">
        </div>
        <div>
            <label for="auteur">Auteur</label>
            <input type="text" id="auteur" name="auteur">
        </div>
        <div>
            <label for="annee">Année</label>
            <input type="text" id="annee" name="annee">
        </div>
        <div>
            <label for="genre">Genre</label><br>
            <select name="genre" id="genre" style="width :100%">
                <option value="">Sélectionnez...</option>
                <option value="Hip-hop">Hip-hop</option>
                <option value="Pop">Pop</option>
                <option value="Rock">Rock</option>
                <option value="Musique électronique">Musique électronique</option>
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