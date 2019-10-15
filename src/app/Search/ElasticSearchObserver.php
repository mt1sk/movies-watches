<?php

namespace App\Search;


use Elasticsearch\Client;
use Illuminate\Database\Eloquent\Model;

class ElasticSearchObserver
{
    protected $elasticSearch;

    public function __construct(Client $client)
    {
        $this->elasticSearch = $client;
    }

    public function saved(Model $model)
    {
        $this->elasticSearch->index($model->getSearchIndexParams());
    }

    public function deleted(Model $model)
    {
        $this->elasticSearch->delete([
            'index' => $model->getSearchIndex(),
            'id' => $model->getKey(),
        ]);
    }
}