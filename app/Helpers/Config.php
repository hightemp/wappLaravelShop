<?php

use Illuminate\Filesystem\Filesystem;

function fnLocalConfigGet($sName, $sDefaultValue='')
{
	static $aLocalConfig;

	if (!$aLocalConfig) {
		$oFileSystem = new Filesystem();
		$sFilePath = fnBasePath('config', 'local.json');

		if ($oFileSystem->exists($sFilePath)) {
			try {
				$aLocalConfig = json_decode($oFileSystem->get($sFilePath), true);
			} catch (\Exception $oException) {
				$aLocalConfig = [];
			}
		}
	}

	return isset($aLocalConfig[$sName]) ? $aLocalConfig[$sName] : $sDefaultValue;
}