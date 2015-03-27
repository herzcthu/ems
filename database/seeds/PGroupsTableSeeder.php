<?php
use App\PGroups;
use Illuminate\Database\Seeder;
use Bican\Roles\Models\Role;
use App\User as User;

class PGroupsTableSeeder extends Seeder {

    /**
     *
     */
    public function run() {
        //Role::truncate();

        PGroups::create([
            'name' => 'Default',
            'descriptions' => 'Default Group'
        ]);
    }
}