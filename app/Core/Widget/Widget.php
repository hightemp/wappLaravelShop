<?php

namespace App\Core\Widget;

abstract class Widget
{
    protected $_sPath;

    function __construct()
    {
        $oReflection = new ReflectionClass(get_class($this));
        $this->_sPath = dirname($oReflection->getFileName());
    }

    public function fnRender()
    {
        
        //throw new Exception("Method not declared");
    }

    public function fnBegin()
    {
        throw new Exception("Method not declared");        
    }

    public function fnEnd()
    {
        throw new Exception("Method not declared");        
    }
}