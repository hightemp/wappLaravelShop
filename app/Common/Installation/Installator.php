<?php

namespace App\Common\Installation;

use Artisan;
use PDO;

class Installator
{
	public static function fnIsInstalled()
	{
		return file_exists(fnPath(base_path(), "installed"));
	}

	public static function fnInstall()
	{
		unlink(fnPath(base_path(), "installed"));

		$oPDO = self::fnGetPDOConnection();
		$oPDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$sConnectionType = config("database.default");
		$sDatabaseName = config("database.connections.$sConnectionType.database");

		$oPDO->exec("DROP DATABASE IF EXISTS `$sDatabaseName`;");
		$oPDO->exec(sprintf(
			"CREATE DATABASE IF NOT EXISTS `%s` CHARACTER SET '%s' COLLATE '%s';",
			$sDatabaseName,
			'utf8',
			'utf8_unicode_ci'
		));

		Artisan::call('migrate');

		self::fnComplete();
	}

	public static function fnGetPDOConnection()
	{
		static $oPDO = null;

		if ($oPDO)
			return $oPDO;

		$sConnectionType = config("database.default");

		$oPDO = new PDO(
			sprintf(
				'mysql:host=%s;port=%d;', 
				config("database.connections.$sConnectionType.host"), 
				config("database.connections.$sConnectionType.port")
			), 
			config("database.connections.$sConnectionType.username"),
			config("database.connections.$sConnectionType.password")
		);

		return $oPDO;
	}

	public static function fnComplete()
	{
		file_put_contents(fnPath(base_path(), "installed"), "");
	}
}