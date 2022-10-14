<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

require 'vendor/autoload.php';

use Carbon\Carbon;

class GuestsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $param = [
        'identify_key' => 'notGuest',
        'created_at' => Carbon::now(), // 現在時刻
        'updated_at' => Carbon::now(), // 現在時刻
      ];
      DB::table('guests')->insert($param);
    }
}
