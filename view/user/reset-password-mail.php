<?php
$GLOBALS['PAGE_TITLE'] = 'Réinitialiser mon mot de passe';
addCSS('edit-profile.css');
require_view('view/header.php');
?>

<h2>Réinitialiser mon mot de passe</h2>

<!-- Submission via AJAX (POST) -->
<form action="post-reset-password-mail">

	<label for="mail">Adresse email</label>
	<input name="mail" id="mail" type="text" placeholder="james.chaintron@gmail.com" value="james.chaintron@gmail.com" required>
	<p><br></p>
	<input class="BigButton" type="submit" value="Envoyer le mail de récupération">

</form>

<div id="feedback"></div>

<?php
require_view('view/footer.php');
?>