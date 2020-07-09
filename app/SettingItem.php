<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SettingItem extends Model
{
	protected $table = "setting_items";
	protected $fillable = ['settings_id', 'name', 'display_name', 'type', 'description', 'sort', 'value'];

	protected static $logFillable = true;

	public function group()
	{
		return $this->belongsTo('App\Setting', 'settings_id');
	}
}
