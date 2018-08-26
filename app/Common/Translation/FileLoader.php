<?php

namespace App\Common\Translation;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Translation\LoaderInterface;

class FileLoader implements LoaderInterface
{
    /**
     * The filesystem instance.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $_oFileSystem;

    /**
     * The default path for the loader.
     *
     * @var array
     */
    protected $_aPaths = [];

    /**
     * All of the namespace hints.
     *
     * @var array
     */
    protected $_aHints = [];

    /**
     * Create a new file loader instance.
     *
     * @param  \Illuminate\Filesystem\Filesystem  $files
     * @param  string  $path
     * @return void
     */
    public function __construct(Filesystem $oFileSystem, Array $aPaths)
    {
        $this->_aPaths = $aPaths;
        $this->_oFileSystem = $oFileSystem;
    }

    /**
     * Adds new path.
     *
     * @param  string  $sPath
     * @return void
     */
    public function fnAddPath($sPath)
    {
        $this->_aPaths[] = $sPath;
    }

    /**
     * Get paths.
     *
     * @return array
     */
    public function fnGetPaths()
    {
        return $this->_aPaths;
    }


    public function fnGetLanguages()
    {
        $aLanguages = [];

        foreach ($this->_aPaths as $sPath) {
            $aFilesPaths = glob("{$sPath}/*");

            foreach ($aFilesPaths as &$sFilePath) {
                $aLanguages[basename($sFilePath)] = true;
            }
        }

        return array_keys($aLanguages);
    }

    /**
     * Load the messages for the given locale.
     *
     * @param  string  $locale
     * @param  string  $group
     * @param  string  $namespace
     * @return array
     */
    public function load($sLocale, $sGroup, $sNamespace = null)
    {
        $aResult = [];

        if ($sGroup == '*' && $sNamespace == '*') {
            foreach ($this->_aPaths as $sPath) {
                $aResult = array_merge($aResult, $this->loadJsonPath($sPath, $sLocale));
            }

            foreach ($this->_aPaths as $sPath) {
                $aResult = array_merge($aResult, $this->loadPathAll($sPath, $sLocale));
            }

            return $aResult;
        }

        if (is_null($sNamespace) || $sNamespace == '*') {
            foreach ($this->_aPaths as $sPath) {
                $aResult = array_merge($aResult, $this->loadPath($sPath, $sLocale, $sGroup));
            }

            return $aResult;
        }

        if ($sGroup == '*') {
            $aResult = $this->loadPathAll($this->_aHints[$sNamespace], $sLocale);
        } else {
            $aResult = $this->loadNamespaced($sLocale, $sGroup, $sNamespace);
        }

        return $aResult;
    }

    /**
     * Load a namespaced translation group.
     *
     * @param  string  $locale
     * @param  string  $group
     * @param  string  $namespace
     * @return array
     */
    protected function loadNamespaced($sLocale, $sGroup, $sNamespace)
    {
        if (isset($this->_aHints[$sNamespace])) {
            $aLines = $this->loadPath($this->_aHints[$sNamespace], $sLocale, $sGroup);

            return $this->loadNamespaceOverrides($aLines, $sLocale, $sGroup, $sNamespace);
        }

        return [];
    }

    /**
     * Load a local namespaced translation group for overrides.
     *
     * @param  array  $lines
     * @param  string  $locale
     * @param  string  $group
     * @param  string  $namespace
     * @return array
     */
    protected function loadNamespaceOverrides(array $aLines, $sLocale, $sGroup, $sNamespace)
    {
        foreach ($this->_aPaths as $sPath) {
            $sFile = "{$sPath}/vendor/{$sNamespace}/{$sLocale}/{$sGroup}.php";

            if ($this->_oFileSystem->exists($sFile)) {
                return array_replace_recursive($aLines, $this->_oFileSystem->getRequire($sFile));
            }
        }

        return $aLines;
    }

    /**
     * Load a locale from a given path.
     *
     * @param  string  $path
     * @param  string  $locale
     * @param  string  $group
     * @return array
     */
    protected function loadPath($sPath, $sLocale, $sGroup)
    {
        if ($this->_oFileSystem->exists($sFile = "{$sPath}/{$sLocale}/{$sGroup}.php")) {
            return $this->_oFileSystem->getRequire($sFile);
        }

        return [];
    }

    /**
     * Load a locale from a given path.
     *
     * @param  string  $path
     * @param  string  $locale
     * @return array
     */
    protected function loadPathAll($sPath, $sLocale)
    {
        $aFiles = glob("{$sPath}/{$sLocale}/*.php");
        $aResult = [];

        foreach ($aFiles as $sFile) {
            $aResult = array_merge($aResult, $this->_oFileSystem->getRequire($sFile));
        }

        return $aResult;
    }
    /**
     * Load a locale from the given JSON file path.
     *
     * @param  string  $path
     * @param  string  $locale
     * @return array
     */
    protected function loadJsonPath($sPath, $sLocale)
    {
        if ($this->_oFileSystem->exists($sFile = "{$sPath}/{$sLocale}.json")) {
            return json_decode($this->_oFileSystem->get($sFile), true);
        }

        return [];
    }

    /**
     * Add a new namespace to the loader.
     *
     * @param  string  $namespace
     * @param  string  $hint
     * @return void
     */
    public function addNamespace($sNamespace, $sHint)
    {
        $this->_aHints[$sNamespace] = $sHint;
    }

    /**
     * Get an array of all the registered namespaces.
     *
     * @return array
     */
    public function namespaces()
    {
        return $this->_aHints;
    }
}
