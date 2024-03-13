<?php
$GLOBALS['PAGE_TITLE'] = 'Sign In';
addCSS('login.css');
require_view('view/header.php');
?>

<h1>Log into your SoundInShape account</h1>

<!-- Submission via AJAX (POST) -->
<div class="form-container">
	<h2>Log In</h2>

	<form action="<?= url('/post-login') ?>">
		<div>
			<label for="mail">Email Address</label>
			<input name="mail" id="mail" type="email" class="form-control" placeholder="james.chaintron@gmail.com" value="james.chaintron@gmail.com" required />
		</div>

		<div>
			<label for="password">Password</label>
			<input name="password" id="password" type="password" class="form-control" placeholder="***" value="abcdefA1!" required />
		</div>

		<input type="submit" id="submit" class="BigButton" value="Se connecter">

		<p><br><a href="reset-password-mail">Password forgotten ?</a></p>

		<p id="feedback"></p>
	</form>
</div>

<div id="feedback"></div>

<?php
require_view('view/footer.php');
?>