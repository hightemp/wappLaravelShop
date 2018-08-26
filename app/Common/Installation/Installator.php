<?php

namespace App\Common\Installation;

use Artisan;
use PDO;

class Installator
{
	public static function fnIsInstalled()
	{
		if (request()->is("install")) {
			return false;
		}

		$oFileSystem = app()['files'];
		
		return $oFileSystem->exists(fnBasePath("config/local.json"));
	}

	public static function fnInstall($aParameters)
	{
		$oFileSystem = app()['files'];

		$oFileSystem->delete(fnBasePath("config/local.json"));

		if (mb_strlen($aParameters["sAdminDir"])<10)
			throw new \Exception("admin_dir_min_length", 90000);

		if (!preg_match("/[a-zA-Z0-9]+/", $aParameters["sAdminDir"]))
			throw new \Exception("admin_dir_characters", 90001);

		if (mb_strlen($aParameters["sSuperAdministratorLogin"])<6)
			throw new \Exception("admin_login_min_length", 90002);

		if (!preg_match("/[a-zA-Z0-9@]+/", $aParameters["sSuperAdministratorLogin"]))
			throw new \Exception("admin_login_characters", 90003);

		if (mb_strlen($aParameters["sSuperAdministratorPassword"])<8)
			throw new \Exception("admin_password_min_length", 90004);

		$sConnectionType = $aParameters["sDatabaseDriver"];

		$oPDO = new PDO(
			sprintf(
				'%s:host=%s;port=%d;', 
				$aParameters["sDatabaseDriver"],
				$aParameters["sDatabaseHost"], 
				$aParameters["sDatabasePort"]
			), 
			$aParameters["sDatabaseUserName"],
			$aParameters["sDatabasePassword"]
		);

		$oPDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$sDatabaseName = $aParameters["sDatabaseName"];

		if (isset($aParameters['bDatabaseCreate']) && $aParameters['bDatabaseCreate']) {
			$oPDO->exec("DROP DATABASE IF EXISTS `$sDatabaseName`;");
			$oPDO->exec(sprintf(
				"CREATE DATABASE IF NOT EXISTS `%s` CHARACTER SET '%s' COLLATE '%s';",
				$sDatabaseName,
				'utf8',
				'utf8_unicode_ci'
			));
		}

		$oDBS = $oPDO->query("SHOW DATABASES;");

		$aDatabases = $oDBS->fetchAll();
		$aDatabases = array_map(function($aItem) { return $aItem['Database']; }, $aDatabases);

		if (!in_array($sDatabaseName, $aDatabases))
			throw new \Exception("database_doesnt_exist", 90005);

		$oPDO->exec("USE `$sDatabaseName`;");

		//Artisan::call('migrate');

		$oFileSystem->put(fnBasePath("config/local.json"), json_encode($aParameters, JSON_PRETTY_PRINT));
	}
}