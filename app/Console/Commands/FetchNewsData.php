<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

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

        $result = resolve('App\Services\ArticleService')->saveAllFetchedNewsApies();

        if (is_array($result) === false) {
            $this->warn('Failed to fetch and store news data.');

            return;
        }

        if (count($result) < 1) {
            $this->warn('There is not news data.');

            return;
        }

        $this->info('News data fetched and stored successfully.');
    }
}
