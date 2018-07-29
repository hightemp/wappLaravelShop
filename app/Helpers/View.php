<?php

function fnAdminView(...$aArguments)
{
	$aArguments[0] = "Backend." . $aArguments[0];
	
	return view(...$aArguments);
}

function fnAdminCSSMix(...$aArguments)
{
	$aArguments[0] = "/css/Admin/" . $aArguments[0];
	
	return mix(...$aArguments);
}

function fnAdminJSMix(...$aArguments)
{
	$aArguments[0] = "/js/Admin/" . $aArguments[0];
	
	return mix(...$aArguments);
}

function fnThemeView(...$aArguments)
{
	$aArguments[0] = "Frontend.Default." . $aArguments[0];
	
	return view(...$aArguments);
}

function fnResponseThemeView(...$aArguments)
{
	$aArguments[0] = "Frontend.Default." . $aArguments[0];
	
	return response()->view(...$aArguments);
}

function fnThemeCSSMix(...$aArguments)
{
	$aArguments[0] = "/css/Default/" . $aArguments[0];
	
	return mix(...$aArguments);
}
