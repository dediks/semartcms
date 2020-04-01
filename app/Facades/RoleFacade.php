<?php
namespace App\Facades;

use Spatie\Permission\Models\Role;

class RoleFacade
{
	public function all()
	{
		return Role::all();
	}

    public function find($id)
    {
        return Role::find($id);
    }

    public function forSelect()
    {
        $items = [];

        foreach($this->all() as $item) {
            $items[$item->id] = $item->name;
        }

        return $items;
    }
}
