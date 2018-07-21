<!DOCTYPE html>
<html>
<head>
	<meta name="csrf-token" content="<?php echo csrf_token() ?>">

	<title><?php echo $sTitle ?></title>
	<link rel="stylesheet" href="<?php echo mix('/css/styles.css') ?>">
	<script src="<?php echo mix('/js/scripts.js') ?>"></script>
</head>
<body>
	<div class="container">
		<div>
			<h2>Сканер прокси-сайтов</h2>
		</div>
		<?php echo $sContent ?>
	</div>
</body>
</html>