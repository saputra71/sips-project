<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CreateKasubagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'Rendi',
            'email' => 'kasubag@gmail.com',
            'password' => bcrypt('12345678'),
        ]);

        $role = Role::create(['name' => 'kasubag']);

        $permissions = Permission::whereNotIn('name', ['ingoing-dispos'])->pluck('id', 'id')->all();

        $role->syncPermissions($permissions);

        $user->assignRole([$role->id]);
    }
}
