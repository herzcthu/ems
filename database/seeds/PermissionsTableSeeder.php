<?php
use Illuminate\Database\Seeder;
use Bican\Roles\Models\Permission;
use Bican\Roles\Models\Role;
use App\User as User;

class PermissionsTableSeeder extends Seeder {

    public function run() {
        //Permission::truncate();

        $add_users = Permission::create([
            'name' => 'Add Users',
            'slug' => 'add.users',
            'model' => 'App\User',
            'description' => '' // optional
        ]);
        $edit_users = Permission::create([
            'name' => 'Edit Users',
            'slug' => 'edit.users',
            'model' => 'App\User',
            'description' => '' // optional
        ]);
        $add_role = Permission::create([
            'name' => 'Add Role',
            'slug' => 'add.role',
            'model' => 'App\User',
            'description' => '' // optional
        ]);
        $edit_role = Permission::create([
            'name' => 'Change Role',
            'slug' => 'edit.role',
            'model' => 'App\User',
            'description' => '' // optional
        ]);
        $edit_user = Permission::create([
            'name' => 'Edit User',
            'slug' => 'edit.user',
            'model' => 'App\User',
            'description' => '' // optional
        ]);
        $import_users = Permission::create([
            'name' => 'Import Users',
            'slug' => 'import.users',
            'model' => 'App\User',
            'description' => '' // optional
        ]);
        $export_users = Permission::create([
            'name' => 'Export Users',
            'slug' => 'export.users',
            'model' => 'App\User',
            'description' => '' // optional
        ]);
        $import_csv = Permission::create([
            'name' => 'Import CSV',
            'slug' => 'import.csv',
            'description' => '' // optional
        ]);
        $export_csv = Permission::create([
            'name' => 'Export CSV',
            'slug' => 'export.csv',
            'description' => '' // optional
        ]);
        $create_form = Permission::create([
            'name' => 'Create Form',
            'slug' => 'create.form',
            'description' => '' // optional
        ]);
        $edit_form = Permission::create([
            'name' => 'Edit Form',
            'slug' => 'edit.form',
            'description' => '' // optional
        ]);
        $view_form = Permission::create([
            'name' => 'View Form',
            'slug' => 'view.form',
            'description' => '' // optional
        ]);
        $add_data = Permission::create([
            'name' => 'Add Data Entry',
            'slug' => 'add.data',
            'description' => '' // optional
        ]);
        $edit_data = Permission::create([
            'name' => 'Edit Data',
            'slug' => 'edit.data',
            'description' => '' // optional
        ]);
        $view_table = Permission::create([
            'name' => 'View table',
            'slug' => 'view.table',
            'description' => '' // optional
        ]);
        
        $admin_permissions = compact(   'add_users', 'edit_users', 'edit_user', 'add_role', 'edit_role',
                            'import_users', 'export_users', 'import_csv', 'export_csv', 'create_form',
                            'edit_form', 'view_form', 'add_data', 'edit_data', 'view_table');
        foreach ($admin_permissions as $permission) {
            Role::find(1)->attachPermission($permission);
        }
        $staff_permissions = compact(   'add_users', 'edit_users', 'edit_user', 'add_role', 'edit_role',
            'import_users', 'export_users', 'import_csv', 'export_csv', 'create_form',
            'edit_form', 'view_form', 'add_data', 'edit_data', 'view_table');
        foreach ($staff_permissions as $permission) {
            Role::find(2)->attachPermission($permission);
        }
        $dataentry_permissions = compact( 'edit_user', 'view_form', 'add_data', 'edit_data', 'view_table');
        foreach ($dataentry_permissions as $permission) {
            Role::find(3)->attachPermission($permission);
        }
        $analyst_permissions = compact( 'edit_user', 'export_csv', 'view_form', 'view_table');
        foreach ($analyst_permissions as $permission) {
            Role::find(4)->attachPermission($permission);
        }
    }
}