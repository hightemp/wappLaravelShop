<?php

function __($sKey = null, $aReplace = [], $sLocale = null)
{
	$aParsedKey = app('translator')->parseKey($sKey);

	if (is_null($aParsedKey[2])) {
		$sKey = "*::*.{$aParsedKey[1]}";
	}

    return app('translator')->getFromJson($sKey, $aReplace, $sLocale);
}
