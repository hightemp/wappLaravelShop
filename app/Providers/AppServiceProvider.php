<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
      if (!is_null(request()->debug)) {
        Config::set('app.debug', true);
      }
      
      if (!is_null(request()->cc)) {
        Artisan::call('cache:clear');
      }
      /*
        DB::listen(function($in_objQuery)
        {
            dump($in_objQuery);
        });
      */
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
