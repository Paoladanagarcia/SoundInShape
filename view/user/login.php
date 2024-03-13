<?php
$GLOBALS['PAGE_TITLE'] = 'Connectez-vous';
addCSS('login.css');
require_view('view/header.php');
?>

<h1>Se connecter à son compte SoundInShape</h1>

<!-- Submission via AJAX (POST) -->
<div class="form-container">
	<h2>Se connecter</h2>

	<form action="<?= url('/post-login') ?>">
		<div>
			<label for="mail">Adresse email</label>
			<input name="mail" id="mail" type="email" class="form-control" placeholder="james.chaintron@gmail.com" value="james.chaintron@gmail.com" required />
		</div>

		<div>
			<label for="password">Mot de passe</label>
			<input name="password" id="password" type="password" class="form-control" placeholder="***" value="abcdefA1!" required />
		</div>

		<input type="submit" id="submit" class="BigButton" value="Se connecter">

		<p><br><a href="reset-password-mail">Mot de passe oublié ?</a></p>

		<p id="feedback"></p>
	</form>
</div>

<div id="feedback"></div>

<?php
require_view('view/footer.php');
?>