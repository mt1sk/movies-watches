<?php

namespace App\Console\Commands;

use App\Movie;
use Elasticsearch\Client;
use Illuminate\Console\Command;

class ReindexCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'search:reindex';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Indexes all movies to Elasticsearch';

    private $elasticSearch;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Client $client)
    {
        parent::__construct();
        $this->elasticSearch = $client;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Indexing all articles. This might take a while...');

        $movie = new Movie();
        $params = ['index' => $movie->getSearchIndex()];
        if ($this->elasticSearch->indices()->exists($params)) {
            $this->elasticSearch->indices()->delete($params);
        }
        foreach (Movie::query()->orderBy('created_at', 'desc')->cursor() as $movie) {
            $this->elasticSearch->index($movie->getSearchIndexParams());
            $this->output->write('.');
        }
        $this->info('Done!');

        return true;
    }
}
