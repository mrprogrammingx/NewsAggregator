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

        $response = $this->post('/api/articles', $data);
        $response->assertStatus(201)
            ->assertJsonFragment(['title' => 'Title 1']);

        $this->assertDatabaseHas('articles', ['url' => 'https://google.com']);

    }

    public function test_can_store_articles()
    {

        $payload = [
            'url' => 'https://google.com',
            'title' => 'Test Article',
            'api_source' => ApiSources::NEWSAPIORG->value,
            'content' => 'This is a test article.',
            'category' => 'Technology',
            'description' => 'description',
            'source' => 'BBC News',
            'author' => 'John Doe',
            'language' => 'en',
            'url_to_image' => 'https://google.com',
            'published_at' => now()->toIso8601String(),
        ];

        $response = $this->postJson('/api/articles', $payload);

        $response->assertStatus(201)
                 ->assertJsonFragment(['title' => 'Test Article']);

        $this->assertDatabaseHas('articles', ['title' => 'Test Article']);
    }
}
