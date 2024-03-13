<?php
$GLOBALS['PAGE_TITLE'] = 'Nous Contacter';
$GLOBALS['BOOTSTRAP'] = false;
addCSS('edit-profile.css');
require_view('view/header.php');
?>

<form action="<?= url('/post-contact-form') ?>">
	<div>
		<label for="mail">Adresse email</label>
		<input name="mail" id="mail" type="email" class="form-control" placeholder="james.chaintron@gmail.com" value="james.chaintron@gmail.com" required />
	</div>

	<div>
		<label for="msg">Votre message :</label>
		<textarea name="msg" id="msg" class="form-control" placeholder="Votre message" required>Bonjour,</textarea>
	</div>

	<p></p>

	<input type="submit" id="submit" class="BigButton" value="Envoyer le message">

	<div id="feedback"></div>
</form>

<?php
require_view('view/footer.php');
?>