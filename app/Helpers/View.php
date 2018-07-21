<?php

function admin_view($sTemplateName)
{
	$aArguments = func_get_args();
	$aArguments[0] = "Backend." . $aArguments[0];
	
	return call_user_func_array("view", $aArguments);
}

function admin_css_mix($sFileName)
{
	$aArguments = func_get_args();
	$aArguments[0] = "/css/Admin/" . $aArguments[0];
	
	return call_user_func_array("mix", $aArguments);
}

function admin_js_mix($sFileName)
{
	$aArguments = func_get_args();
	$aArguments[0] = "/js/Admin/" . $aArguments[0];
	
	return call_user_func_array("mix", $aArguments);
}

function theme_view($sTemplateName)
{
	$aArguments = func_get_args();
	$aArguments[0] = "Frontend.Default." . $aArguments[0];
	
	return call_user_func_array("view", $aArguments);
}

function theme_css_mix($sFileName)
{
	$aArguments = func_get_args();
	$aArguments[0] = "/css/Default/" . $aArguments[0];
	
	return call_user_func_array("mix", $aArguments);
}
