<?php
global $user;
$GLOBALS['PAGE_TITLE'] = 'Manage Club';
addCSS('dashboard.css');
require_view('view/header.php');
?>

<h1><?= $GLOBALS['PAGE_TITLE'] ?></h1>

<!-- Display a table id, name, nb_rooms, opening_hour, closing_hour from club -->
<div class="container">
	<div class="form-container">
		<h1 class="text-center"><?= $GLOBALS['PAGE_TITLE'] ?></h1>

		<form action="<?= url('/post-manage-club') ?>" method="post">
			<input type="hidden" name="club_id" value="<?= $club['club_id'] ?>" />

			<div class="form-group">
				<label for="name">Name</label>
				<input type="text" name="name" id="name" value="<?= $club['name'] ?>" />
			</div>
			<div class="form-group">
				<label for="nb_rooms">Nb of rooms</label>
				<input type="number" name="nb_rooms" id="nb_rooms" value="<?= $club['nb_rooms'] ?>" />
			</div>
			<div class="form-group">
				<label for="opening_hour">Opening Hour</label>
				<input type="time" name="opening_hour" id="opening_hour" value="<?= $club['opening_hour'] ?>" />
			</div>
			<div class="form-group">
				<label for="closing_hour">Closing Hour</label>
				<input type="time" name="closing_hour" id="closing_hour" value="<?= $club['closing_hour'] ?>" />
			</div>

			<div class="form-group">
				<input class="BigButton" type="submit" value="Validate" />
			</div>

			<div id="feedback"></div>
		</form>
	</div>
</div>

<?php
require_view('view/footer.php');
?>