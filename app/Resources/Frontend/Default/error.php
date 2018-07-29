<!DOCTYPE html>
<html>
<head>
	<meta name="csrf-token" content="<?php echo csrf_token() ?>">

	<title><?php echo __("error") ?></title>
	
	<link rel="stylesheet" href="<?php echo mix('/css/styles.css') ?>">
	<link rel="stylesheet" href="<?php echo fnThemeCSSMix('styles.css') ?>">
	<script src="<?php echo mix('/js/scripts.js') ?>"></script>
</head>
<body>
	<div class="container">
		<?php echo fnThemeView("errors.$iStatus") ?>
	</div>
</body>
</html>