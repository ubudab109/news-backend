<?php

namespace App\Sources\NewsAPIORG;

use App\Sources\AbstractArticleAdapter;
use App\Sources\TransformedArticle;
use App\Sources\TransformedAuthor;

class ArticleAdapter extends AbstractArticleAdapter
{
    /**
     * Get the article data from NewsAPI Org
     * Then save them to database
     * @return bool
     * @throws \Exception
     */
    public function createOrUpdateArticle()
    {
        $categories = $this->client->dataServices->getCategories();
        $param = [
            'apiKey'  => $this->source->key,
            'country' => 'us',
        ];
        foreach($categories as $category) {
            $param['category'] = $category;
            $query = http_build_query($param);
            $request = $this->client->request('get', 'top-headlines?'. $query);
            $response = json_decode($request->getBody(), true);
            if($response['status'] == 'ok') {
                $articles = $response['articles'];
                foreach($articles as $article) {
                    /**
                     * Cause the response does not have main identifier
                     * we need to format the external id from published date and source author
                     */
                    $externalId = strtotime($article['publishedAt']) .'-'. $article['source']['id'] ?? '';

                    // Formatting authors
                    $author = [$article['source']['id'] ?? $article['source']['name']];
                    if($article['author']) {
                        $author[] = $article['author'];
                    }

                    /**
                     * We need to saving authors from article
                     * since the Authors API not all have content articles
                     */
                    $transformedAuthor = new TransformedAuthor($article['source']['id'] ?? $article['source']['name'], $article['author'] ?? $article['source']['name'], null);
                    $saveAuthor = $transformedAuthor->createOrUpdateAuthor($this->source);
                    if(!$saveAuthor) {
                        throw new \Exception('Failed saving authors data from News Api Org');
                    }

                    $transformedArticles = new TransformedArticle($externalId, json_encode($author) , json_encode([$category]), str_replace(',', '', clean($article['title'])), 
                    $article['content'] ?? $article['title'], $article['urlToImage'] ?? null, $article['publishedAt'], $article['url'] ?? null);
                    $saveArticle = $transformedArticles->createOrUpdateArticle($this->source);
                    if(!$saveArticle) {
                        throw new \Exception('Failed saving articles from News Api Org');
                    }
                }
            } else {
                throw new \Exception('Failed fetching data articles from News Api Org');
            }
        }
        return true;
    }
}