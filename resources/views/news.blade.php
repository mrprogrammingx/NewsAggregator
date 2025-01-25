<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News Articles</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">News Articles</h1>
        @foreach($articles as $article)
            <div class="card mb-4">
                <div class="card-body">
                    <h2 class="card-title">{{ $article['title'] }}</h2>
                    <p class="text-muted mb-1">
                        <strong>ID:</strong> {{ $article['id'] }} |
                        <strong>Author:</strong> {{ $article['author'] ?? 'Unknown' }} |
                        <strong>Source:</strong> {{ $article['source'] ?? 'Unknown' }} |
                        <strong>API Source:</strong> {{ $article['api_source'] ?? 'Unknown' }} |
                        <strong>Category:</strong> {{ $article['category'] ?? 'General' }}
                    </p>
                    <p class="card-text"><strong>Description:</strong> {{ $article['description'] ?? 'No description available' }}</p>
                    <p class="card-text">{{ $article['content'] }}</p>
                    @if($article['url'])
                        <a href="{{ $article['url'] }}" class="btn btn-primary" target="_blank">Read Full Article</a>
                    @endif
                    <p class="text-muted mt-2">
                        <strong>Published At:</strong> {{ $article['published_at'] ?? 'N/A' }} |
                        <strong>Created At:</strong> {{ $article['created_at'] ?? 'N/A' }} |
                        <strong>Updated At:</strong> {{ $article['updated_at'] ?? 'N/A' }}
                    </p>
                </div>
            </div>
        @endforeach
    </div>
</body>
</html>