<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

require 'vendor/autoload.php';

use Carbon\Carbon;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      //初期カテゴリ一覧（41個）
      $categories = array('芸能', 'Youtuber', 'アーティスト', 'スポーツ', '運動・筋トレ', '音楽', '動物', 'SNS', 'テレビ・ラジオ番組', 'アニメ', 'ゲーム', 'お笑い', '漫画', '小説', '本・書籍', 'ITガジェット', '時事・ニュース', '最新技術', '趣味', '食事', '旅行', '家電', '自動車', 'お金・投資', '世界', '社会', '政治', '経済', '地域', '文化', '歴史', '学問・研究', '勉強', '睡眠', 'ダイエット', '生活', '相談', '雑談', 'ギャンブル', 'メンタル系', 'その他');

      foreach ($categories as $category) {
        $param = [
          'name' => $category,
          'created_at' => Carbon::now(), // 現在時刻
        ];
        DB::table('categories')->insert($param);
      }
    }
}
