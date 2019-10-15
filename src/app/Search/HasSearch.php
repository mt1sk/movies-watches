<?php

namespace App\Search;


trait HasSearch
{
    public static function bootSearchable()
    {
        if (config('services.elasticsearch.enabled')) {
            static::observe(ElasticSearchObserver::class);
        }
    }

    public function getSearchIndex()
    {
        return $this->getTable();
    }

    public function toSearchArray()
    {
        return $this->toArray();
    }

    public function getSearchIndexParams()
    {
        $params = [
            'index' => $this->getSearchIndex(),
            'id' => $this->getKey(),
            'body' => $this->toSearchArray(),
        ];
        return $params;
    }
}