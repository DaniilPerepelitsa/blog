<?php


namespace App\Http\Services;

use App\Models\Post;
use Illuminate\Support\Arr;
use Elasticsearch\Client;
use Illuminate\Support\Collection;

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
                        'fields' => ['title', 'content'],
                        'query' => $query,
                        'fuzziness' => 'AUTO'
                    ]
                ]
            ]
        ]);
    }

    public function buildCollection(array $items){
        $ids = Arr::pluck($items['hits']['hits'], '_id');
        $posts = Post::find($ids)->keyBy('id');
        $result = new Collection();

        foreach ($ids as $id) {
            if ($posts->has($id)) {
                $result->push($posts->get($id));
            }
        }

        return $result;
    }
}
