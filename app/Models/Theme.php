<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Theme extends Model
{
	protected $table = 'Themes';
	protected $primaryKey = 'iThemeID';
	public $timestamps = false;

	protected $fillable = ['iParentThemeID', 'sName', 'bStatus'];

  public function fnGetPath()
  {
    return fnAppPath("Resources", "Frontend", $this->sName);
  }
  
}