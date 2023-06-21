<?php

namespace App\Jobs;

use App\Models\Source;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class AuthorImportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $sources = Source::all();
        foreach ($sources as $source) {
            $adapter = $source->getAuthorAdapter();
            $adapter->createOrUpdateAuthors();
        }
    }
}
