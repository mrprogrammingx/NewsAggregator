<?php

namespace App;

enum DataSources: string
{
    case NEWSAPI = 'news_api';
    case OPENNEWS = 'open_news';
    case NEWSCRED = 'news_cred';
    case THEGUARDIAN = 'the_guardian';
    case NEWYORKTIMES = 'new_york_times';
    case BBCNEWS = 'bbc_news';
    case NEWSAPIORG = 'news_api_org';

    public function name() : string
    {
        return match($this){
            self::NEWSAPI => 'NewsAPI',
            self::OPENNEWS => 'OpenNews',
            self::NEWSCRED => 'NewsCred',
            self::THEGUARDIAN => 'The Guardian',
            self::NEWYORKTIMES => 'New York Times',
            self::BBCNEWS => 'BBC News',
            self::NEWSAPIORG => 'NewsAPI.org',
        };
    }
}
