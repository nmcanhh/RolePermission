<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->insert([
            [
                'id' => 1,
                'name' => 'user-list',
                'display_name' => 'Danh sách người dùng',
            ],
            [
                'id' => 2,
                'name' => 'user-add',
                'display_name' => 'Thêm người dùng',
            ],
            [
                'id' => 3,
                'name' => 'user-edit',
                'display_name' => 'Sửa người dùng',
            ],
            [
                'id' => 4,
                'name' => 'user-delete',
                'display_name' => 'Xóa người dùng',
            ],
            [
                'id' => 5,
                'name' => 'role-list',
                'display_name' => 'Danh sách quyền',
            ],
            [
                'id' => 6,
                'name' => 'role-add',
                'display_name' => 'Thêm quyền',
            ],
            [
                'id' => 7,
                'name' => 'role-edit',
                'display_name' => 'Sửa quyền',
            ],
            [
                'id' => 8,
                'name' => 'role-delete',
                'display_name' => 'Xóa quyền',
            ]
        ]);


    }
}
