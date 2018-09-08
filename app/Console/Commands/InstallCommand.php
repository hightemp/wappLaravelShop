<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Core\Installation\Installator;
use Exception;
use Validator;

class InstallCommand extends Command
{
    protected $description = 'Installation';
    protected $signature = 'ls:install {--file=}';

    public function fnValidate($oMethod, $aRules)
    {
        $sValue = $oMethod();
        $bValidate = $this->fnValidateInput($aRules, $sValue);

        if ($bValidate !== true) {
            $this->warn($bValidate);
            $sValue = $this->fnValidate($oMethod, $aRules);
        }
        return $sValue;
    }

    public function fnValidateInput($aRules, $sValue)
    {
        $oValidator = Validator::make([$aRules[0] => $sValue], [$aRules[0] => $aRules[1]], trans('validation'));

        if ($oValidator->fails()) {
            $oError = $oValidator->errors();
            return $oError->first($aRules[0]);
        }else{
            return true;
        }
    }

    public function handle()
    {
        try {

            $aParameters = [];

            if ($sFile = $this->option('file')) {
                $oFileSystem = app()['files'];

                $sExtension = pathinfo($sFile, PATHINFO_EXTENSION);
                
                if ($sExtension == 'json') {
                    $aParameters = json_decode($oFileSystem->get($sFile), true);
                } else {
                    $aParameters = parse_ini_file($sFile);
                }
            } else {
                if (!$this->confirm(__('installation_continue?'))) {
                    exit();
                }
                $this->info(__('admin_panel'));
                $aParameters['sAdminDir'] = $this->fnValidate(function() {
                    return $this->ask(__('admin_dir'), false);
                }, ['sAdminDir', 'required|min:10|regex:/[a-zA-Z0-9]+/']);

                $this->info(__('super_administrator'));
                $aParameters['sSuperAdministratorLogin'] = $this->fnValidate(function() {
                    return $this->ask(__('login'), false);
                }, ['sAdminDir', 'required|min:6|regex:/[a-zA-Z0-9@._-]+/']);

                $aParameters['sSuperAdministratorPassword'] = $this->fnValidate(function() {
                    return $this->secret(__('password'), false);
                }, ['sAdminDir', 'required|min:8']);

                $this->info(__('database'));
                $aParameters['sDatabaseDriver'] = $this->ask(__('database_driver_type'), 'mysql');
                $aParameters['sDatabaseHost'] = $this->ask(__('database_host'), '127.0.0.1');
                $aParameters['sDatabasePort'] = $this->ask(__('database_port'), false);
                $aParameters['sDatabaseUserName'] = $this->ask(__('database_user_name'), false);
                $aParameters['sDatabasePassword'] = $this->ask(__('database_password'), false);
                $aParameters['sDatabaseName'] = $this->ask(__('database_name'), 'wappLaravelShop');
                $aParameters['sDatabaseSocket'] = $this->ask(__('database_socket'), false);

                $aParameters['bDatabaseCreate'] = $this->confirm(__('database_create'));
            }

            Installator::fnInstall($aParameters);

        } catch (Exception $oException) {
            $this->error($oException->getMessage());
        }
    }
}