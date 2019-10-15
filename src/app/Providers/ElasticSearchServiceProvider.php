<?php

namespace App\Providers;

use App\Movie;
use App\Movies\EloquentSearch;
use App\Movies\MovieSearch;
use App\Search\ElasticSearch;
use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;
use Illuminate\Support\ServiceProvider;

class ElasticSearchServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->bindSearchClient();

        $concrete = config('services.elasticsearch.enabled') ? ElasticSearch::class : EloquentSearch::class;
        $this->app->bind(MovieSearch::class, $concrete);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Movie::bootSearchable();
    }

    private function bindSearchClient()
    {
        $this->app->bind(Client::class, function ($app) {
            return ClientBuilder::create()
                ->setHosts($app['config']->get('services.elasticsearch.hosts'))
                ->build();
        });
    }
}
