<?php


namespace App\Http\Services;

use App\Models\Post;
use Illuminate\Support\Arr;
use Elasticsearch\Client;
use Symfony\Component\Process\Process;

class ElasticSearch
{
    private $elasticsearch;
    private $postModel;

    public function __construct(Client $elasticsearch, Post $post){
        $this->elasticsearch = $elasticsearch;
        $this->postModel = $post;
    }

    public function search(string $query = ''){
        return $this->buildCollection(
            $this->searchOnElasticSearch($query)
        );
    }

    public function searchOnElasticSearch(string $query = ''){
        return $this->elasticsearch->search([
           'index' => $this->postModel->getSearchIndex(),
            'type' => $this->postModel->getSearchType(),
            'body' => [
                'size' => 1000,
                'query' => [
                    'multi_match' => [
                        'fields' => ['title'],
                        'query' => $query,
                        'fuzziness' => 'AUTO'
                    ]
                ]
            ]
        ]);
    }

    public function buildCollection(array $items){
        $ids = Arr::pluck($items['hits']['hits'], '_id');
        $idsOrdered = implode(',', $ids);

        return Post::whereIn('id', $ids)->orderByRaw('FIELD(id,'.$idsOrdered.')');

    }
}
