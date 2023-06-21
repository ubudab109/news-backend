<?php

namespace Database\Seeders;

use App\Models\Source;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;

class SourceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sources')->insert([
            [
                'id'   => Source::NEWS_API_AI,
                'name' => 'NewsAPIAI',
                'key'  => config('app.news_api_ai_key'),
                'created_at' => Date::now(),
                'updated_at' => Date::now(),
            ],
            [
                'id'   => Source::THE_GUARDIAN,
                'name' => 'TheGuardian',
                'key'  => config('app.guardian_api_key'),
                'created_at' => Date::now(),
                'updated_at' => Date::now(),
            ],
            [
                'id'   => Source::NEWS_API_ORG,
                'name' => 'NewsAPIORG',
                'key'  => config('app.news_api_org_key'),
                'created_at' => Date::now(),
                'updated_at' => Date::now(),
            ],
        ]);
    }
}
