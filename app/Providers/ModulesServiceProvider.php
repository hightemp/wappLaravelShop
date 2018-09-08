<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Core\Module\ModulesManager;

class ModulesServiceProvider extends ServiceProvider
{
  public function register()
  {
    $this->app->singleton('modules.manager', function ($oApp) {
      return new ModulesManager(
      	$oApp['files']
      );
    });
  }

  public function boot()
  {
    $this->app->make('modules.manager');
  }

}
