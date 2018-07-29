<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class HelpersServiceProvider extends ServiceProvider
{
  public function register()
  {
    $aHelpersPaths = fnAppPathGlob("Helpers", "**", "*.php");

    foreach($aHelpersPaths as $aHelperPath) {
      require_once $aHelperPath;
    }

    $aHelpersPaths = fnAppPathGlob("Helpers", "*.php");

    foreach($aHelpersPaths as $aHelperPath) {
      require_once $aHelperPath;
    }
  }
}
