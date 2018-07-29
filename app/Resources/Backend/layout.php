<!DOCTYPE html>
<html>
<head>
	<meta name="csrf-token" content="<?php echo csrf_token() ?>">

	<title><?php echo $sTitle ?></title>

	<link rel="stylesheet" href="<?php echo fnAdminCSSMix('styles.css') ?>">
	<script src="<?php echo fnAdminJSMix('scripts.js') ?>"></script>
</head>
<body>
	<div class="container">
		<?php echo $sContent ?>
	</div>
</body>
</html>