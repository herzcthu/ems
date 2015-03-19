<?php
use Illuminate\Database\Seeder;
use Bican\Roles\Models\Role;
use App\User as User;
 
class RolesTableSeeder extends Seeder {
 
    public function run() {
        Role::truncate();

		Role::create([
			'name' => 'Admin',
			'slug' => 'admin',
		  	'level' => '10',
			'description' => '' // optional
		]);
		Role::create([
		    'name' => 'Offic Staff',
		    'slug' => 'staff',
			'level' => '9',
		    'description' => '' // optional
		]);
		Role::create([
			'name' => 'Data Entry',
			'slug' => 'dataentry',
			'level' => '5',
		 	'description' => '' // optional
		]);
		Role::create([
			'name' => 'Analyst',
			'slug' => 'analyst',
			'level' => '1',
			'description' => '' // optional
		]);
		//User::find(1)->attachRole(1);

    }
}