<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Core\Preprocessor\Preprocessor;

class PreprocessorServiceProvider extends ServiceProvider
{
  public function register()
  {
    $this->app->singleton('preprocessor', function ($oApp) {
      return new Preprocessor(
      	$oApp['files']
      );
    });
  }

  public function boot()
  {
    if (!$this->app->runningInConsole()) {
      $oPreprocessor = $this->app->make('preprocessor');
      $oPreprocessor->fnProcess();
    }
  }
}
