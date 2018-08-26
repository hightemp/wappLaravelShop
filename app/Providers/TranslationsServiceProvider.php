<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Common\Translation\FileLoader;
use Illuminate\Translation\Translator;

class TranslationsServiceProvider extends ServiceProvider
{

	//protected $defer = true;
	
  public function register()
  {
    $this->registerLoader();

    $this->app->singleton('translator', function ($oApp) {
      $sLoader = $oApp['translation.loader'];
      $sLocale = $oApp['config']['app.locale'];

      $oTranslator = new Translator($sLoader, $sLocale);

      $oTranslator->setFallback($oApp['config']['app.fallback_locale']);

      return $oTranslator;
    });
  }

  protected function registerLoader()
  {
    $this->app->singleton('translation.loader', function ($oApp) {
      return new FileLoader(
      	$oApp['files'], 
      	[
      		$oApp['path.lang'],
      		fnAppPath("Language"),
      	]
      );
    });
  }

  public function boot()
  {
    $oTranslationLoader = app()->make('translation.loader');

    config([ 'app.aLanguages' => $oTranslationLoader->fnGetLanguages() ]);
  }

  public function provides()
  {
    return ['translator', 'translation.loader'];
  }
}