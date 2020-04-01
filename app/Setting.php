<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{

	protected $table = "settings";
	protected $fillable = ['name', 'display_name', 'description', 'sort'];

	protected static $logFillable = true;

	public function items() {
		return $this->hasMany('App\SettingItem', 'settings_id');
	}
}
