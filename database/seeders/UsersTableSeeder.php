<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

require 'vendor/autoload.php';

use Carbon\Carbon;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $param = [
        'email' => 'guest@guest.com',
        'password' => '11111111',
        'nickname' => null,
        'icon_image_path' => null,
        'created_at' => Carbon::now(), // 現在時刻
        'updated_at' => Carbon::now(), // 現在時刻
      ];
      DB::table('users')->insert($param);
    }
}
