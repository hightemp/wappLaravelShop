<?php

namespace App\Core\Utils;

class StringUtils
{
	public static function fnRandomString($iLength) 
	{
		$aKeys = array_merge(range(0, 9), range('a', 'z'));

		$sKey = "";
		for($iIndex=0; $iIndex < $iLength; $iIndex++) {
		  $sKey .= $aKeys[mt_rand(0, count($aKeys) - 1)];
		}
		return $sKey;
	}
}