# News Aggregator API

## Overview

This project is a **News Aggregator API** designed to fetch, store, and provide access to news articles from various sources via API endpoints. It supports filtering, searching, and pagination to meet the needs of front-end applications.
    
---

## Features

- Fetch and store news articles from multiple APIs.
- Filter articles by category, source, author, date range, etc.
- Search articles by keywords.
- Paginated responses for efficient data retrieval.
- Robust error handling and logging.

---

## Supported API News

- NewsAPI.org
- New York Times
- The Guardian


## Technologies

- **Backend Framework**: Laravel
- **Database**: MySQL
- **Logging**: Laravel Log with custom error logs.
- **Testing**: PHPUnit, Mockery
- **OS Platform**: Docker, Laravel Sail
- **Design patterns**: Factory, Adapter, Service, Repository
  
---

## Installation

### Prerequisites

- PHP >= 8.1
- Composer
- MySQL
- Laravel

### Steps

1. Clone the repository:

   ```bash
   git clone https://github.com/binahayat00/NewsAggregator
   cd NewsAggregator
   ```

2. Install dependencies:

   ```bash
   composer install
   ```

3. Set up the `.env` file:

   ```bash
   cp .env.example .env
   ```

   Update the `.env` file with your database credentials and other environment variables and api_keys.
   
4. Get your `API Keys` (At least one of this list) and Added to your `.env` file:
    - NewsAPI.org:
   ```bash
    NEWS_API_ORG_KEY=your_api_key
   ```

    - New York Times:
   ```bash
    THE_GUARDIAN_KEY=your_api_key
   ```
   
    - The Guardian:
   ```bash
    NEW_YORK_TIMES_KEY=your_api_key
   ```
   When you add your `API_KEY` to `.env` for each of the API sources, the API source will be automatically active.
7. Build Docker and Laravel Sail Containers:

   ```bash
   ./vendor/bin/sail artisan build
   ```
   
8. Start the development server:

   ```bash
   ./vendor/bin/sail artisan up -d
   ```
   
9. Run database migrations:

   ```bash
   /vendor/bin/sail artisan migrate
   ```
   
10. Run Schedule:
    For fetching News APIs command automatically and saving in the database.
   ```bash
   /vendor/bin/sail artisan schedule:work 
   ```
---

## API Endpoints

### Articles

#### Fetch Articles

- **Endpoint**: `GET /api/articles/filter`
- **Query Parameters**:
  - `search`: Search term.
  - `category`: Article category.
  - `source`: Source name.
  - `author`: Author name.
  - `api_source`: Api Source , available API sources:
      - news\_api
      - open\_news
      - news\_cred
      - the\_guardian
      - new\_york\_times 
      - bbc\_news&#x20;
      - news\_api\_org 

  - `date_from`: Start date for filtering.
  - `date_to`: End date for filtering.
  - `per_page`: Number of articles per page.

#### Example:

```bash
GET /api/articles/filter?search=technology&category=General&per_page=5
```

#### Response:

```json
{
  "data": [
    {
    "id": 1,
    "title": "Five Action Movies to Stream Now",
    "author": "By Robert Daniels",
    "api_source": "new_york_times",
    "source": "The New York Times",
    "description": "This month’s picks include craven rich kids, retired assassins and a cat cult.",
    "category": "Movies",
    "language": "",
    "url_to_image": "images/2024/01/09/multimedia/beekeeper1-kvzq/beekeeper1-kvzq-articleLarge.jpg",
    "url": "https://www.nytimes.com/2025/01/24/movies/action-movies-streaming.html",
    "content": "There have been plenty of ...",
    "published_at": "January 26, 2025, 11:53 AM",
    "created_at": "January 26, 2025, 11:15 AM",
    "updated_at": "January 26, 2025, 11:58 AM" 
    }
  ],
  "pagination": {
    "total": 50,
    "per_page": 5,
    "current_page": 1
  }
}
```

### Fetch Articles from APIs

This feature allows you to fetch articles from active news APIs either manually or automatically.

#### Manual Execution

- **Command**: Run the following command to fetch articles from active APIs:  
  ```bash
  /vendor/bin/sail artisan app:fetch-news-data
  ```

#### Automatic Updates

- To enable automatic updates, run the Laravel scheduler:  
  ```bash
  /vendor/bin/sail artisan schedule:work
  ```
- Any errors encountered during scheduling, fetching, or storing will be logged in the application's log file. You can review the logs to identify and resolve any issues.
---

## Testing

1. Run PHPUnit tests:
   ```bash
   php artisan test
   ```
2. Mock external API sources and validate the functionality of services and controllers.

---

## Project Structure

- `App/Services`: Contains business logic for fetching and storing articles.
- `App/Http/Controllers`: Handles API requests and responses.
- `App/Http/Resources`: Formats API responses for frontend compatibility.
- `App/Http/Requests`: Validates API inputs.
- `App/Contracts`: Contains interfaces.
- `App/Http/Repositories`: Works with Models.
---

## Contributing

1. Fork the repository.
2. Create a feature branch.
3. Commit your changes.
4. Push the branch and create a pull request.

---

## License

This project is licensed under the MIT License.

---

## Author

**Amir**

