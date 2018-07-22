<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Common\Installation\Installator;
use Exception;

class DatabaseInstallCommand extends Command
{
    protected $description = 'Database installation';
    protected $signature = 'db:install';

    public function handle()
    {
        try {
            Installator::fnInstall();

        } catch (Exception $oException) {
            $this->error($oException->getMessage());
        }
    }
}