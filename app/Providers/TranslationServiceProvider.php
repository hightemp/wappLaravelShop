<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Common\Translation\FileLoader;
use Illuminate\Translation\Translator;

class TranslationServiceProvider extends ServiceProvider
{

	protected $defer = true;
	
  public function register()
  {
      $this->registerLoader();

      $this->app->singleton('translator', function ($oApp) {
          $sLoader = $oApp['translation.loader'];
          $sLocale = $oApp['config']['app.locale'];

          $trans = new Translator($sLoader, $sLocale);

          $trans->setFallback($oApp['config']['app.fallback_locale']);

          return $trans;
      });
  }

  protected function registerLoader()
  {
      $this->app->singleton('translation.loader', function ($oApp) {
          return new FileLoader(
          	$oApp['files'], 
          	[
          		$oApp['path.lang'],
          		app_path().DIRECTORY_SEPARATOR."Language",
          	]
          );
      });
  }

  public function provides()
  {
      return ['translator', 'translation.loader'];
  }
}