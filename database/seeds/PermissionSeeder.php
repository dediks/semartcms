<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\User;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'manage-content-model',
            'manage-users',
            'manage-api',
            'manage-settings',
            'manage-plugins'
        ];

        foreach($permissions as $permission) {
        	$check = Permission::whereName($permission)->count();
        	if(!$check) {    		
	        	Permission::create([
	        		'name' => $permission
	        	]);
        		$this->command->info('[OK] Permission "' . $permission . '" created successfully.');
        	}else{
        		$this->command->info('[Skip] Permission "' . $permission . '" already exist.');
        	}
        }

          $role = Role::create(['name' => 'super-admin']);
          $role->givePermissionTo(Permission::all());
          
          $user = User::find(1);
          $user->assignRole('super-admin');
    }
}
