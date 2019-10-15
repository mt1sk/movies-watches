<?php

namespace App\Search;


use App\Movie;
use App\Movies\MovieSearch;
use Elasticsearch\Client;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;

class ElasticSearch implements MovieSearch
{
    protected $elasticSearch;

    public function __construct(Client $client)
    {
        $this->elasticSearch = $client;
    }

    public function search(string $query): Collection
    {
        $items = $this->searchOnElasticSearch($query);

        return $this->buildCollection($items);
    }

    private function searchOnElasticSearch(string $query): array
    {
        $model = new Movie();

        $items = $this->elasticSearch->search([
            'index' => $model->getSearchIndex(),
            'body' => [
                'query' => [
                    'multi_match' => [
                        'fields' => ['name'],
                        'query' => $query,
                        'fuzziness' => 2,
                    ],
                ],
            ],
        ]);

        return $items;
    }

    private function buildCollection(array $items): Collection
    {
        $ids = Arr::pluck($items['hits']['hits'], '_id');

        return Movie::query()->findMany($ids)
            ->sortBy(function ($movie) use ($ids) {
                return array_search($movie->getKey(), $ids);
            });
    }
}