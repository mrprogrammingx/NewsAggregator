<?php

namespace Tests\Feature;

use App\Http\Requests\ArticleStoreRequest;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class ArticleRequestTest extends TestCase
{
    public function test_validation_rules_for_article_store_request()
    {
        $request = new ArticleStoreRequest;

        $data = [
            'title' => '',
            'content' => '',
            'category' => '',
            'source' => '',
            'author' => '',
            'published_at' => 'invalid-date',
        ];

        $validator = Validator::make($data, $request->rules());

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('title', $validator->errors()->toArray());
        $this->assertArrayHasKey('published_at', $validator->errors()->toArray());
    }
}
