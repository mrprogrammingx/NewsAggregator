<?php

namespace Tests\Feature;

use App\Enums\ApiSources;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ArticleApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_retrieve_articles()
    {
        $response = $this->get('/api/articles');
        $response->assertStatus(200);
    }

    public function test_can_store_article()
    {
        $data = [
            'url' => 'https://google.com',
            'title' => 'Title 1',
            'api_source' => ApiSources::NEWSAPIORG->value,
            'source' => 'NewsAPI',
            'author' => 'Alex',
            'description' => 'description',
            'category' => 'news',
            'language' => 'en',
            'url_to_image' => 'https://google.com',
            'content' => 'content',
            'published_at' => now()->format('Y/m/d'),
        ];
        $response = $this->post('/api/articles/store', $data);
        $response->assertStatus(200);

    }

    public function test_can_fetch()
    {
        //TODO 
        // need mock test
        $response = $this->get('/api/articles/fetch');
        $response->assertStatus(200);
    }
}
