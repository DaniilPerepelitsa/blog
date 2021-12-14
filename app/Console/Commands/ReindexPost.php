<?php


namespace App\Console\Commands;

use App\Models\Post;
use Elasticsearch\Client;
use Illuminate\Console\Command;

class ReindexPost extends Command
{
    protected $signature = 'search:reindex';
    protected $description = 'Indexes all posts to Elasticsearch';
    private $elasticsearch;
    private $post;

    public function __construct(Client $elasticsearch, Post $post)
    {
        parent::__construct();

        $this->elasticsearch = $elasticsearch;
        $this->post = $post;
    }

    public function handle(){
        $this->info('Indexes all posts');
        try {
            $this->elasticsearch->indices()->delete(['index' => $this->post->getSearchIndex()]);
        }catch (\Exception $e){}

        $this->elasticsearch->indices()->create($this->settings());
//        dd($response);

        foreach (Post::cursor() as $post){
            $this->elasticsearch->index([
               'index' => $post->getSearchIndex(),
                'type' => $post->getSearchType(),
                'id' => $post->getKey(),
                'body' => $post->toSearchArray()
            ]);

            $this->output->write('.');
        }
        $this->info('done');
    }

    public function settings(){
        return [
            'index' => config('services.search.index'),
            'body' => [
                'settings' => [
                    'analysis' => [
                        'filter' => [
                            'russian_stop' => [
                                'type' => 'stop',
                                'stopwords' => '_russian_'
                            ],
                            'shingle' => [
                                'type' => 'shingle'
                            ],
                            'mynGram' => [
                                'type' => 'edge_ngram',
                                'min_gram' => 3,
                                'max_gram' => 10
                            ],
                            'length_filter' => [
                                'type' => 'length',
                                'min' => 3
                            ],
                            'russian_stemmer' => [
                                'type' => 'stemmer',
                                'language' => 'russian'
                            ],
                            'english_stemmer' => [
                                'type' => 'stemmer',
                                'language' => 'english'
                            ]
                        ],
                        'analyzer' => [
                            'title' => [
                                'type' => 'custom',
                                'tokenizer' => 'standard',
                                'filter' => [
                                    'lowercase',
                                    'mynGram',
                                    'length_filter',
                                    'trim',
                                    'russian_stemmer',
                                    'english_stemmer',
                                    'russian_stop'
                                ]
                            ]
                        ]
                    ]
                ],
                'mappings' => [
                    'properties' => [
                        'title' => [
                            'type' => 'text',
                            'analyzer' => 'title'
                        ]
                    ]
                ]
            ]
        ];
    }
}
