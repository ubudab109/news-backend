<?php

namespace Database\Seeders;

use App\Jobs\AuthorImportJob;
use App\Jobs\CategoryImportJob;
use App\Jobs\ImportArticleJob;
use Illuminate\Database\Seeder;

class SourcesArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CategoryImportJob::dispatch();
        AuthorImportJob::dispatch();
        ImportArticleJob::dispatch();
    }
}
