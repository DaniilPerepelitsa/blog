<?php


namespace App\Traits;

use App\Observers\ElasticsearchObserver;

trait Searchable
{
    public static function bootSearchable(){
        static::observe(ElasticsearchObserver::class);
    }

    public function getSearchIndex(): string
    {
        return env('APP_NAME').$this->getTable();
    }

    public function getSearchType(): string
    {
        return '_doc';
    }

    public function toSearchArray(): array
    {
        return [
            'title' => $this->title
        ];
    }
}
