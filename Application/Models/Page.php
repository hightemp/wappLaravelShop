<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $table = 'pages';
    
    static protected $sViewPath;
    static protected $sLayoutPath;
    
    static function getViewPath()
    {
        $sViewPath = resource_path('views');
        return $sViewPath;
    }
    
    static function getLayoutPath()
    {
        $sLayoutPath = self::getViewPath() . "/layouts";
        return $sLayoutPath;
    }
    
    static function getTemplates()
    {        
        $aLayouts = include(self::getLayoutPath()."/layouts.php");
        
        return $aLayouts;
    }
    
    static function isTemplate($in_sTemplateName)
    {
        return in_array($in_sTemplateName, self::getTemplates());
    }
}
