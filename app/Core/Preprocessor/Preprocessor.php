<?php

namespace App\Core\Preprocessor;

use Illuminate\Support\Facades\Cache;
use App\Core\Installation\Installator;
use App\Models\Module;
use App\Managers\ModulesManager;
use App\Managers\ThemesManager;
use Leafo\ScssPhp;
use MatthiasMullie\Minify;

class Preprocessor
{
  /**
   * @var Illuminate\Filesystem\Filesystem
   */
  protected $_oFileSystem;

  function __construct($oFileSystem)
  {
    $this->_oFileSystem = $oFileSystem;
  }

  public function fnProcess($bForce = false)
  {
    $sCachePath = config("cache.stores.file.path");
    
    $this->_oFileSystem->makeDirectory($sCachePath, 0755, true, true);

    $sCSSPath = public_path('css');
    $sJSPath = public_path('js');
    
    $this->_oFileSystem->makeDirectory($sCSSPath, 0755, false, true);
    $this->_oFileSystem->makeDirectory($sJSPath, 0755, false, true);

    $sCSSAdminPath = fnPath($sCSSPath, "Admin");
    $sJSAdminPath = fnPath($sJSPath, "Admin");
    
    $this->_oFileSystem->makeDirectory($sCSSAdminPath, 0755, false, true);
    $this->_oFileSystem->makeDirectory($sJSAdminPath, 0755, false, true);
    
    $aStylesFilesMTime = [];
    $aScriptsFilesMTime = [];
    $aStylesFiles = [];
    $aScriptsFiles = [];
    $aMainStylesFiles = [];
    $aThemesStylesFiles = [];
    $aAdminStylesFiles = [];
    $aMainScriptsFiles = [];
    $aThemeScriptsFiles = [];
    $aAdminScriptsFiles = [];

    $aThemesNames = Installator::fnIsInstalled() ? ThemesManager::fnGetAllNames() : ["Default"];
    $aModulesNames = Installator::fnIsInstalled() ? ModulesManager::fnGetAllNames() : [];
    
    $sStyleFilePath = fnBasePath("resources", "assets", "sass", "styles.scss");
    $sStyleCacheFilePath = fnPath($sCachePath, "styles_main.css");
    if ($this->_oFileSystem->exists($sStyleFilePath)) {
      $aMainStylesFiles[] = $sStyleCacheFilePath;
      $aAdminStylesFiles[] = $sStyleCacheFilePath;
      $aStylesFiles[$sStyleFilePath] = $sStyleCacheFilePath;
      $aStylesFilesMTime[$sStyleFilePath] = filemtime($sStyleFilePath);
    }

    foreach ($aThemesNames as $sThemeName) {
      $aThemesStylesFiles[$sThemeName] = [];
      
      $sCSSThemePath = fnPath($sCSSPath, $sThemeName);

      $this->_oFileSystem->makeDirectory($sCSSThemePath, 0755, false, true);

      $sStyleFilePath = fnAppPath("Resources", "Frontend", $sThemeName, "sass", "styles.scss");
      $sStyleCacheFilePath = fnPath($sCachePath, "styles_theme_$sThemeName.css");
      if ($this->_oFileSystem->exists($sStyleFilePath)) {
        $aThemesStylesFiles[$sThemeName][] = $sStyleCacheFilePath;
        $aStylesFiles[$sStyleFilePath] = $sStyleCacheFilePath;
        $aStylesFilesMTime[$sStyleFilePath] = filemtime($sStyleFilePath);
      }
    }

    $sStyleFilePath = fnAppPath("Resources", "Backend", "sass", "styles.scss");
    $sStyleCacheFilePath = fnPath($sCachePath, "styles_admin_main.css");
    if ($this->_oFileSystem->exists($sStyleFilePath)) {
      $aAdminStylesFiles[] = $sStyleCacheFilePath;
      $aStylesFiles[$sStyleFilePath] = $sStyleCacheFilePath;
      $aStylesFilesMTime[$sStyleFilePath] = filemtime($sStyleFilePath);
    }

    foreach ($aModulesNames as $sModuleName) {
      
      $sStyleFilePath = fnAppPath("Modules", $sModuleName, "Resources", "Frontend", "Module", "sass", "styles.scss");
      $sStyleCacheFilePath = fnPath($sCachePath, "styles_module_{$sModuleName}_main.css");
      if ($this->_oFileSystem->exists($sStyleFilePath)) {
        $aMainStylesFiles[] = $sStyleCacheFilePath;
        $aStylesFiles[$sStyleFilePath] = $sStyleCacheFilePath;
        $aStylesFilesMTime[$sStyleFilePath] = filemtime($sStyleFilePath);
      }

      foreach ($aThemesNames as $sThemeName) {
        
        $sStyleFilePath = fnAppPath("Modules", $sModuleName, "Resources", "Frontend", $sThemeName, "sass", "styles.scss");
        $sStyleCacheFilePath = fnPath($sCachePath, "styles_module_{$sModuleName}_theme_$sThemeName.css");
        if ($this->_oFileSystem->exists($sStyleFilePath)) {
          $aThemesStylesFiles[$sThemeName][] = $sStyleCacheFilePath;
          $aStylesFiles[$sStyleFilePath] = $sStyleCacheFilePath;
          $aStylesFilesMTime[$sStyleFilePath] = filemtime($sStyleFilePath);
        }
        
      }
      
      $sStyleFilePath = fnAppPath("Modules", $sModuleName, "Resources", "Backend", "sass", "styles.scss");
      $sStyleCacheFilePath = fnPath($sCachePath, "styles_admin_module_{$sModuleName}.css");
      if ($this->_oFileSystem->exists($sStyleFilePath)) {
        $aAdminStylesFiles[] = $sStyleCacheFilePath;
        $aStylesFiles[$sStyleFilePath] = $sStyleCacheFilePath;
        $aStylesFilesMTime[$sStyleFilePath] = filemtime($sStyleFilePath);
      }      
    }
    
    $sScriptFilePath = fnBasePath("resources", "assets", "js", "scripts.js");
    $sScriptCacheFilePath = fnPath($sCachePath, "scripts_main.js");
    if ($this->_oFileSystem->exists($sScriptFilePath)) {
      $aMainScriptsFiles[] = $sScriptCacheFilePath;
      $aAdminScriptsFiles[] = $sScriptCacheFilePath;
      $aScriptsFiles[$sScriptFilePath] = $sScriptCacheFilePath;
      $aScriptsFilesMTime[$sScriptFilePath] = filemtime($sScriptFilePath);
    }

    foreach ($aThemesNames as $sThemeName) {
      $aThemesScriptsFiles[$sThemeName] = [];
      
      $sJSThemePath = fnPath($sJSPath, $sThemeName);

      $this->_oFileSystem->makeDirectory($sJSThemePath, 0755, false, true);

      $sScriptFilePath = fnAppPath("Resources", "Frontend", $sThemeName, "js", "scripts.js");
      $sScriptCacheFilePath = fnPath($sCachePath, "scripts_theme_$sThemeName.js");
      if ($this->_oFileSystem->exists($sScriptFilePath)) {
        $aThemesScriptsFiles[$sThemeName][] = $sScriptCacheFilePath;
        $aScriptsFiles[$sScriptFilePath] = $sScriptCacheFilePath;
        $aScriptsFilesMTime[$sScriptFilePath] = filemtime($sScriptFilePath);
      }
    }

    $sScriptFilePath = fnAppPath("Resources", "Backend", "js", "scripts.js");
    $sScriptCacheFilePath = fnPath($sCachePath, "scripts_admin_main.js");
    if ($this->_oFileSystem->exists($sScriptFilePath)) {
      $aAdminScriptsFiles[] = $sScriptCacheFilePath;
      $aScriptsFiles[$sScriptFilePath] = $sScriptCacheFilePath;
      $aScriptsFilesMTime[$sScriptFilePath] = filemtime($sScriptFilePath);
    }

    foreach ($aModulesNames as $sModuleName) {
      
      $sScriptFilePath = fnAppPath("Modules", $sModuleName, "Resources", "Frontend", "Module", "js", "scripts.js");
      $sScriptCacheFilePath = fnPath($sCachePath, "scripts_module_{$sModuleName}_main.js");
      if ($this->_oFileSystem->exists($sScriptFilePath)) {
        $aMainScriptsFiles[] = $sScriptCacheFilePath;
        $aScriptsFiles[$sScriptFilePath] = $sScriptCacheFilePath;
        $aScriptsFilesMTime[$sScriptFilePath] = filemtime($sScriptFilePath);
      }

      foreach ($aThemesNames as $sThemeName) {
        
        $sScriptFilePath = fnAppPath("Modules", $sModuleName, "Resources", "Frontend", $sThemeName, "js", "scripts.js");
        $sScriptCacheFilePath = fnPath($sCachePath, "scripts_module_{$sModuleName}_theme_$sThemeName.js");
        if ($this->_oFileSystem->exists($sScriptFilePath)) {
          $aThemesScriptsFiles[$sThemeName][] = $sScriptCacheFilePath;
          $aScriptsFiles[$sScriptFilePath] = $sScriptCacheFilePath;
          $aScriptsFilesMTime[$sScriptFilePath] = filemtime($sScriptFilePath);
        }
        
      }
      
      $sScriptFilePath = fnAppPath("Modules", $sModuleName, "Resources", "Backend", "js", "scripts.js");
      $sScriptCacheFilePath = fnPath($sCachePath, "scripts_admin_module_{$sModuleName}.js");
      if ($this->_oFileSystem->exists($sScriptFilePath)) {
        $aAdminScriptsFiles[] = $sScriptCacheFilePath;
        $aScriptsFiles[$sScriptFilePath] = $sScriptCacheFilePath;
        $aScriptsFilesMTime[$sScriptFilePath] = filemtime($sScriptFilePath);
      }      
    }
    
    $sKey = "preprocessor.css_files";
    $aCachedFiles = Cache::has($sKey) ? Cache::get($sKey) : [];
    
    $aDiffResult = array_diff_assoc($aStylesFilesMTime, $aCachedFiles);
    
    if (!empty($aDiffResult) || $bForce) {
      set_time_limit(0);

      $this->fnCompileSCSS($aStylesFiles);

      $this->fnCombine($aMainStylesFiles, fnPublicPath("css", "styles.css"));
      foreach ($aThemesNames as $sThemeName) {
        $this->fnCombine($aThemesStylesFiles[$sThemeName], fnPublicPath("css", $sThemeName, "styles.css"));
      }
      $this->fnCombine($aAdminStylesFiles, fnPublicPath("css", "Admin", "styles.css"));

      Cache::put("preprocessor.css_files", $aStylesFilesMTime, config("preprocessing.cache.css"));
    }

    $sKey = "preprocessor.js_files";
    $aCachedFiles = Cache::has($sKey) ? Cache::get($sKey) : [];
    
    $aDiffResult = array_diff_assoc($aScriptsFilesMTime, $aCachedFiles);
    
    if (!empty($aDiffResult) || $bForce) {
      set_time_limit(0);
      
      $this->fnRequireJS($aScriptsFiles);
      $this->fnMinifyJS($aScriptsFiles);

      $this->fnCombine($aMainScriptsFiles, fnPublicPath("js", "scripts.js"), true);
      foreach ($aThemesNames as $sThemeName) {
        $this->fnCombine($aThemesScriptsFiles[$sThemeName], fnPublicPath("js", $sThemeName, "scripts.js"), true);
      }
      $this->fnCombine($aAdminScriptsFiles, fnPublicPath("js", "Admin", "scripts.js"), true);

      Cache::put("preprocessor.js_files", $aScriptsFilesMTime, config("preprocessing.cache.js"));
    }

    return [
      'styles' => $aStylesFilesMTime,
      'scripts' => $aScriptsFilesMTime,
    ];
  }

  public function fnCompileSCSS($aFiles)
  {
    foreach ($aFiles as $sInputFile => $sOutputFile) {
      $oSCSSCompiler = new ScssPhp\Compiler();

      $oSCSSCompiler->setImportPaths(dirname($sInputFile));

      $sResult = $oSCSSCompiler->compile(
          $this->_oFileSystem->get($sInputFile)
      );

      $this->_oFileSystem->put($sOutputFile, $sResult);
    }
  }
  
  public function fnMinifyJS($aFiles)
  {
    foreach ($aFiles as $sInputFile => $sOutputFile) {
      $oJSMinifier = new Minify\JS($sOutputFile);

      $oJSMinifier->minify($sOutputFile);
    }
  }
  
  public function fnRequireJS($in_aFiles, $in_sRequirePath=null, $in_aParents=[])
  {
    foreach ($in_aFiles as $sInputFile => $sOutputFile) {
      $sFile = '';
      $sRequirePath = '';
      
      if (is_null($in_sRequirePath)) {
        $sRequirePath = dirname($sInputFile);
        $sFile = $sInputFile;
      } else {
        $sRequirePath = $in_sRequirePath;
        $sFile = $sOutputFile;
      }
      
      $sContents = $this->_oFileSystem->get($sFile);

      preg_match_all("/require\s*\(\s*[\"']([^\"']*)[\"']\s*\)\s*;?/im", $sContents, $aMatches);
      
      foreach($aMatches[1] as $iKey => $sMatch) {
        $sRequiredFile = trim($sMatch);
        $sRequiredFile = preg_replace("/^\.[\/\\\\]+/", "", $sRequiredFile);
        
        if (!preg_match("/^[\/\\\\]+/", $sRequiredFile)) {
          $sRequiredFile = fnPath($sRequirePath, $sRequiredFile);
        }
        
        if (!preg_match("/\.js$/i", $sRequiredFile)) {
          $sRequiredFile = $sRequiredFile . ".js";
        }

        $sRequiredFileContents = "";

        if ($this->_oFileSystem->exists($sRequiredFile)) {
          $sRequiredFileContents = $this->fnRequireJS([$sRequiredFile], $sRequirePath, $in_aParents+[$sFile]);
        }

        $sContents = str_replace($aMatches[0][$iKey], $sRequiredFileContents, $sContents);
        
      }
      
      if (!empty($in_aParents)) {
        return $sContents;
      }
      
      $this->_oFileSystem->put($sOutputFile, $sContents);
    }
  }
  
  public function fnCombine($aFiles, $sOutputFile, $bAddSemicolon=false)
  {
    foreach ($aFiles as &$sFile) {
      $sFile = $this->_oFileSystem->get($sFile);
    }
    
    $sDelimeter = '';
    
    if ($bAddSemicolon) {
      $sDelimeter = ';';
    }
    
    $sResult = implode($sDelimeter, $aFiles);
    
    $this->_oFileSystem->put($sOutputFile, $sResult);
  }
}