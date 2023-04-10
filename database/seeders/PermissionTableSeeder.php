<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'module-pegawai',
            'module-surat',
            'ingoing-dispos',
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',
            'ingoing-list',
            'ingoing-create',
            'ingoing-edit',
            'ingoing-delete',
            'outgoing-list',
            'outgoing-create',
            'outgoing-edit',
            'outgoing-delete',
            'document-list',
            'document-create',
            'document-edit',
            'document-delete',
            'menjabat-list',
            'menjabat-create',
            'menjabat-edit',
            'menjabat-delete',
            'user-list',
            'user-create',
            'user-edit',
            'user-delete',
            'pegawai-list',
            'pegawai-create',
            'pegawai-edit',
            'pegawai-delete',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}
