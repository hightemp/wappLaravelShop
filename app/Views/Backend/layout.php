<!DOCTYPE html>
<html>
<head>
	<meta name="csrf-token" content="<?php echo csrf_token() ?>">

	<title><?php echo $sTitle ?></title>
	
	<link rel="stylesheet" href="<?php echo admin_css_mix('styles.css') ?>">
	<script src="<?php echo admin_js_mix('scripts.js') ?>"></script>
</head>
<body>
	<div class="container">
		<?php echo $sContent ?>
	</div>
</body>
</html>