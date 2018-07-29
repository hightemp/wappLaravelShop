<?php

function fnTrimSlashes(Array &$aArray)
{
  foreach ($aArray as $iKey => &$sItem) {
    if ($iKey == 0) {
      $sItem = rtrim($sItem, "\\/");
    } elseif ($iKey == count($aArray)-1) {
      $sItem = ltrim($sItem, "\\/");
    } else {
      $sItem = trim($sItem, "\\/");
    }
  }
}

function fnPath(...$aArguments) 
{
  fnTrimSlashes($aArguments);
	return implode(DIRECTORY_SEPARATOR, $aArguments);
}

function fnAppPath(...$aArguments) 
{
	array_unshift($aArguments, app_path());
	return fnPath(...$aArguments);
}

function fnBasePath(...$aArguments) 
{
	array_unshift($aArguments, base_path());
	return fnPath(...$aArguments);
}

function fnPublicPath(...$aArguments) 
{
	array_unshift($aArguments, public_path());
	return fnPath(...$aArguments);
}

function fnPathGlob(...$aArguments) 
{
  return app()->files->glob(fnPath(...$aArguments));
}

function fnAppPathGlob(...$aArguments) 
{
  return app()->files->glob(fnAppPath(...$aArguments));
}