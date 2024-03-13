<?php
$GLOBALS['PAGE_TITLE'] = 'Update my password';
addCSS('edit-profile.css');
require_view('view/header.php');
?>

<h2>Update my password</h2>

<!-- Submission via AJAX (POST) -->
<form action="post-reset-password">

	<label for="password1">Choose a strong password</label>
	<input name="password1" id="password1" type="password" placeholder="********" value="abcdefA1!" required>

	<label for="password2">Confirm your password</label>
	<input name="password2" id="password2" type="password" placeholder="********" value="abcdefA1!" required>

	<?php if (isset($_GET['token'])) { ?>
		<input id="token" type="hidden" name="token" value="<?= $_GET['token'] ?>">
	<?php } ?>

	<p><br></p>
	<input class="BigButton" type="submit" value="Update my password">

</form>

<div id="feedback"></div>

<?php
require_view('view/footer.php');
?>