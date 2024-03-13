<?php
$GLOBALS['PAGE_TITLE'] = 'Reset my SoundInShape password';
addCSS('edit-profile.css');
require_view('view/header.php');
?>

<h2>Reset my SoundInShape password</h2>

<!-- Submission via AJAX (POST) -->
<form action="post-reset-password-mail">

	<label for="mail">Email address</label>
	<input name="mail" id="mail" type="text" placeholder="james.chaintron@gmail.com" value="james.chaintron@gmail.com" required>
	<p><br></p>
	<input class="BigButton" type="submit" value="Send reset password email">

</form>

<div id="feedback"></div>

<?php
require_view('view/footer.php');
?>