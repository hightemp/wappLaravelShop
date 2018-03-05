<!DOCTYPE html>
<html lang="en-GB">
  <head>
    <meta charset="UTF-8">
    <title><?php echo $title ?></title>
    <link href="<?php echo asset('css/bootstrap-theme.css'); ?>" rel="stylesheet">
  </head>
  <body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
      <div class="" id="navbarColor01">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item active">
            <a class="nav-link" href="/">Home <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?=url('', [App::getLocale(), 'test'])?>">Features</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Pricing</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">About</a>
          </li>
        </ul>
      </div>
    </nav>

    <?php foreach ($errors->all() as $error): ?>
      <div><?=$error?></div>
    <?php endforeach ?>
    <?php echo $content ?>

    <script type="text/javascript" src="<?php echo asset('js/jquery.min.js') ?>"></script>
    <script type="text/javascript" src="<?php echo asset('js/bootstrap.min.js') ?>"></script>

  </body>
</html>
