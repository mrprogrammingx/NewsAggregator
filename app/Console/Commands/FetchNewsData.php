<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\ArticleService;

class FetchNewsData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fetch-news-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetching All active News APIs';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        resolve('App\Services\ArticleService')->fetchAllNewsApies();
    }
}
