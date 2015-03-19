<?php
use App\GeneralSettings;
use Illuminate\Database\Seeder;
use Bican\Roles\Models\Role;
use App\User as User;
 
class GeneralSettingsTableSeeder extends Seeder {
 
    public function run() {
        GeneralSettings::truncate();

        GeneralSettings::create( [
            'options_name' => 'options' ,
            'options' => array('site_name' => 'EMS','site_descriptions' => 'Election Monitoring System', 'answers_per_question' => 10)
        ] );
    }
}