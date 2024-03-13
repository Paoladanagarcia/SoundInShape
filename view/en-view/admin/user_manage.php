<?php
global $user;
$GLOBALS['PAGE_TITLE'] = 'Manage User';
addCSS('dashboard.css');
require_view('view/header.php');
?>

<h1><?= $GLOBALS['PAGE_TITLE'] ?></h1>

<div class="container">
	<div class="form-container">
		<h1 class="text-center"><?= $GLOBALS['PAGE_TITLE'] ?></h1>

		<form action="<?= url('/post-manage-user') ?>" method="post">
			<input type="hidden" name="user_id" value="<?= $user['user_id'] ?>" />

			<div class="form-group">
				<label for="last_name">Last Name</label>
				<input type="text" name="last_name" id="last_name" class="form-control" value="<?= $user['last_name'] ?>" />
			</div>
			<div class="form-group">
				<label for="first_name">First Name</label>
				<input type="text" name="first_name" id="first_name" class="form-control" value="<?= $user['first_name'] ?>" />
			</div>
			<div class="form-group">
				<label for="birthdate">Date birth</label>
				<input type="date" name="birthdate" id="birthdate" class="form-control" value="<?= $user['birthdate'] ?>" />
			</div>
			<div class="form-group">
				<label for="address">Addresse</label>
				<input type="text" name="address" id="address" class="form-control" value="<?= $user['address'] ?>" />
			</div>
			<div class="form-group">
				<label for="city">City</label>
				<input type="text" name="city" id="city" class="form-control" value="<?= $user['city'] ?>" />
			</div>
			<div class="form-group">
				<label for="postal_code">Postal Code</label>
				<input type="text" name="postal_code" id="postal_code" class="form-control" value="<?= $user['postal_code'] ?>" />
			</div>
			<div class="form-group">
				<label for="mail">Mail</label>
				<input type="email" name="mail" id="mail" class="form-control" value="<?= $user['mail'] ?>" />
			</div>
			<div class="form-group">
				<label for="register_date">Register Date</label>
				<input type="date" name="register_date" id="register_date" class="form-control" value="<?= $user['register_date'] ?>" />
			</div>
			<div class="form-group">
				<label for="password_recovery_token">Reset Password Token</label>
				<input type="text" name="password_recovery_token" id="password_recovery_token" class="form-control" value="<?= $user['password_recovery_token'] ?>" />
			</div>
			<div class="form-group">
				<input type="checkbox" name="registration_approved" id="registration_approved" class="form-control form-check-input" value=1 <?= $user['registration_approved'] ? 'checked' : '' ?>>
				<label for="registration_approved" class="form-check-label">Registration Approved</label>
			</div>
			<div class="form-group">
				<label for="admin_approving">Registration approved by</label>
				<input type="number" name="admin_approving" id="admin_approving" class="form-control" value="<?= $user['admin_approving'] ?>" />
			</div>
			<div class="form-group">
				<label for="club_id">Club Id</label>
				<input type="number" name="club_id" id="club_id" class="form-control" value="<?= $user['club_id'] ?>" />
			</div>
			<div class="form-group">
				<input type="submit" id="submit" value="Update" class="BigButton" />
			</div>

			<div id="feedback"></div>
		</form>
	</div>
</div>

<?php
require_view('view/footer.php');
?>