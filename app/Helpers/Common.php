<?php

function fnPath() 
{
	$aArguments = func_get_args();
	return implode(DIRECTORY_SEPARATOR, $aArguments);
}

function fnAppPath() 
{
	$aArguments = func_get_args();
	array_unshift($aArguments, app_path());
	return implode(DIRECTORY_SEPARATOR, $aArguments);
}