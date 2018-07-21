let oMix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

var oFS = require("fs");
var oGlob = require("glob");

var aStyles = [];
var aAdminStyles = [];

oMix.sass("resources/assets/sass/styles.scss", "public/css/styles_main.css");
aStyles.push("public/css/styles_main.css");

var aFiles = oGlob.sync("app/Views/Frontend/*/sass/styles.scss", {});
for (var sFileKey in aFiles) {
	var sDir = aFiles[sFileKey].match(/Frontend\/(.*)\/sass/)[1];

	if (!oFS.existsSync(`public/css/${sDir}`)){
		oFS.mkdirSync(`public/css/${sDir}`);
	}

	oMix.sass(aFiles[sFileKey], `public/css/${sDir}/styles.css`);
}

if (!oFS.existsSync("public/css/Admin")){
	oFS.mkdirSync("public/css/Admin");
}
oMix.sass("app/Views/Backend/sass/styles.scss", "public/css/Admin/styles_main.css");
aAdminStyles.push("public/css/Admin/styles_main.css");

var aFiles = oGlob.sync("app/Modules/*/Assets/Backend/sass/styles.scss", {}); 
for (var sFileKey in aFiles) {
	oMix.sass(aFiles[sFileKey], `public/css/Admin/styles_${sFileKey}.css`);

	aAdminStyles.push(`public/css/Admin/styles_${sFileKey}.css`);
}

var aFiles = oGlob.sync("app/Modules/*/Assets/Frontend/sass/styles.scss", {}); 
for (var sFileKey in aFiles) {
	oMix.sass(aFiles[sFileKey], `public/css/styles_${sFileKey}.css`);

	aStyles.push(`public/css/styles_${sFileKey}.css`);
}

oMix.combine(aStyles, "public/css/styles.css");
oMix.combine(aAdminStyles, "public/css/Admin/styles.css");

oMix
	.then(() => 
	{
		for (var sStyleKey in aStyles) {
			if (oFS.existsSync(aStyles[sStyleKey])) {
				oFS.unlinkSync(aStyles[sStyleKey]);
			}
		}
		for (var sStyleKey in aAdminStyles) {
			if (oFS.existsSync(aAdminStyles[sStyleKey])) {
				oFS.unlinkSync(aAdminStyles[sStyleKey]);
			}
		}
	});

var aScripts = [];
var aAdminScripts = [];

oMix.js("resources/assets/js/scripts.js", "public/js/scripts_main.js");
aScripts.push("public/js/scripts_main.js");

var aFiles = oGlob.sync("app/Views/Frontend/*/js/scripts.js", {});
for (var sFileKey in aFiles) {
	oMix.js(aFiles[sFileKey], `public/js/scripts_1_${sFileKey}.js`);

	aScripts.push(`public/js/scripts_1_${sFileKey}.js`);
}

if (!oFS.existsSync("public/js/Admin")){
	oFS.mkdirSync("public/js/Admin");
}
oMix.js("app/Views/Backend/js/scripts.js", "public/js/Admin/scripts_main.js");
aAdminScripts.push("public/js/Admin/scripts_main.js");

var aFiles = oGlob.sync("app/Modules/*/Assets/Backend/js/scripts.js", {}); 
for (var sFileKey in aFiles) {
	oMix.js(aFiles[sFileKey], `public/js/Admin/scripts_${sFileKey}.js`);

	aAdminScripts.push(`public/js/Admin/scripts_${sFileKey}.js`);
}

var aFiles = oGlob.sync("app/Modules/*/Assets/Frontend/js/scripts.js", {}); 
for (var sFileKey in aFiles) {
	oMix.js(aFiles[sFileKey], `public/js/scripts_2_${sFileKey}.js`);

	aScripts.push(`public/js/scripts_2_${sFileKey}.js`);
}

oMix.combine(aScripts, "public/js/scripts.js");
oMix.combine(aAdminScripts, "public/js/Admin/scripts.js");

oMix
	.then(() => 
	{
		for (var sScriptKey in aScripts) {
			if (oFS.existsSync(aScripts[sScriptKey])) {
				oFS.unlinkSync(aScripts[sScriptKey]);
			}
		}
		for (var sScriptKey in aAdminScripts) {
			if (oFS.existsSync(aAdminScripts[sScriptKey])) {
				oFS.unlinkSync(aAdminScripts[sScriptKey]);
			}
		}
	});