<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
	protected $table = 'Modules';
	protected $primaryKey = 'iModuleID';
	public $timestamps = false;

	protected $fillable = ['sName', 'bStatus'];

}