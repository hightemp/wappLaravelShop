<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class HelpersServiceProvider extends ServiceProvider
{
  public function register()
  {    
    $aHelpersPaths = glob(app_path().DIRECTORY_SEPARATOR."Helpers".DIRECTORY_SEPARATOR."**".DIRECTORY_SEPARATOR."*.php");

    foreach($aHelpersPaths as $aHelperPath) {
      require_once $aHelperPath;
    }

    $aHelpersPaths = glob(app_path().DIRECTORY_SEPARATOR."Helpers".DIRECTORY_SEPARATOR."*.php");

    foreach($aHelpersPaths as $aHelperPath) {
      require_once $aHelperPath;
    }
  }
}
