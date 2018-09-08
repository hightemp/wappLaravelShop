<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Managers\ModulesManager;
use App\Core\Installation\Installator;

class ModulesServiceProvider extends ServiceProvider
{

  public function boot()
  {
    if (!Installator::fnIsInstalled()) {
      return;
    }

    $aModules = ModulesManager::fnGetAll();

    foreach($aModules as $oModule) {
      $oModule->fnLoadRoutes();
      $oModule->fnLoadViews();
      $oModule->fnLoadTranslations();
      $oModule->fnLoadMigrations();
    }
  }

}
