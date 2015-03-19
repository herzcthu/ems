<?php
use Illuminate\Database\Seeder;
use Bican\Roles\Models\Role;
use App\User as User;

class ParticipantsTypesTableSeeder extends Seeder {

    public function run() {
        //Role::truncate();

        Role::create([
            'name' => 'Coordinator'
        ]);

        Role::create([
            'name' => 'Enumerator'
        ]);

        Role::create([
            'name' => 'Spot Checker'
        ]);
    }
}