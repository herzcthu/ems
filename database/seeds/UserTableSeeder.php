<?php
use Illuminate\Database\Seeder;
use Bican\Roles\Models\Role;
use App\User as User;
 
class UserTableSeeder extends Seeder {
 
    public function run() {
        //User::truncate();

        User::create( [
            'email' => 'sithu@thwin.net' ,
            'password' => Hash::make( 'forever' ) ,
            'name' => 'Sithu Thwin' ,
            'user_gender' => 'male',

        ] );
    }
}