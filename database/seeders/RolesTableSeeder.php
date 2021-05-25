<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            [
                'id' => 1,
                'name' => 'admin',
                'display_name' => 'Quản trị viên',
            ],
            [
                'id' => 2,
                'name' => 'content',
                'display_name' => 'Content',
            ],
            [
                'id' => 3,
                'name' => 'Writer',
                'display_name' => 'Người viết bài',
            ],
        ]);
    }
}
