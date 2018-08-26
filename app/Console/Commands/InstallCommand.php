<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Common\Installation\Installator;
use Exception;

class InstallCommand extends Command
{
    protected $description = 'Installation';
    protected $signature = 'ls:install';

    public function handle()
    {
        try {

            Installator::fnInstall();

        } catch (Exception $oException) {
            $this->error($oException->getMessage());
        }
    }
}