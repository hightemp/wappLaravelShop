<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Exception;

class PrepareAssetsCommand extends Command
{
    protected $description = 'Prepare assets';
    protected $signature = 'ls:prepare_assets';

    public function handle()
    {
        try {
            $fMicroSeconds = microtime(true);

            $oPreprocessor = app()->make('preprocessor');
            $aFiles = $oPreprocessor->fnProcess(true);

            $this->info(__('preprocessing_found_styles', ['number' => count($aFiles['styles'])] ));
            print_r(array_keys($aFiles['styles']));

            $this->info(__('preprocessing_found_scripts', ['number' => count($aFiles['scripts'])] ));
            print_r(array_keys($aFiles['scripts']));

            $fMicroSeconds = microtime(true) - $fMicroSeconds;
            
            $this->info(__('preprocessing_time', ['time' => round($fMicroSeconds*1000)] ));
        } catch (Exception $oException) {
            $this->error($oException->getMessage());
        }
    }
}