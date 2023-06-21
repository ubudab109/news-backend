<?php

namespace App\Sources\NewsApiAI;

use App\Sources\AbstractArticleAdapter;
use App\Sources\TransformedArticle;
use App\Sources\TransformedAuthor;
use App\Sources\TransformedCategory;
use Illuminate\Http\Response;

class ArticleAdapter extends AbstractArticleAdapter
{
    /**
     * Get the article data from NewsAPI AI
     * Then save them to database
     * @return bool
     * @throws \Exception
     */
    public function createOrUpdateArticle()
    {
        $articlesPage = 1;
        // this is a default format for searching the articles
        // the format will be like this '{\"$query\":{\"$and\":[{\"keyword\":\"Articles\",\"keywordLoc\":\"body\"},{\"lang\":\"eng\"}]},\"$filter\":{\"forceMaxDataTimeWindow\":\"31\",\"isDuplicate\":\"skipDuplicates\"}}'
        $querySearching = '%7B%22%24query%22%3A%7B%22keyword%22%3A%22Articles%22%2C%22keywordLoc%22%3A%22body%22%7D%2C%22%24filter%22%3A%7B%22forceMaxDataTimeWindow%22%3A%2231%22%7D%7D';
        $reqParam = [
            'apiKey' => $this->source->key,
            'resultType' => 'articles',
            'articlesSortBy' => 'date',
            'articlesCount'  => 100,
            'includeArticleCategories' => true,
            // we need to get complete body content for description
            'articleBodyLen' => -1,
            'includeSourceTitle' => false,
        ];
        // We need between 500-1000 articles in this Source
        while($articlesPage <= 10) {
            $query = http_build_query($reqParam);
            $response = $this->client->request('GET', 'article/getArticles?'. $query.'&query='.$querySearching.'&articlesPage='.$articlesPage);
            if($response->getStatusCode() == Response::HTTP_OK) {
                $resItem = json_decode($response->getBody(), true);
                    $articles = $resItem['articles']['results'];
                    foreach($articles as $data) {
                        // we need to save articles that have Author and Categories
                        // and we don't want to save the duplicate articles
                        if (!empty($data['authors']) && !empty($data['categories']) && !$data['isDuplicate']) {
                            $categoryString = [];
                            // We need create or update the category data, since the API Categories only have a few categories
                            foreach($data['categories'] as $category) {
                                $categoryString[] = $category['uri'];
                                $explodeCategoryLabel = explode('/', $category['label']);
                                $labelKey = array_key_last($explodeCategoryLabel);
                                $transformedCategories = new TransformedCategory($category['uri'], $explodeCategoryLabel[$labelKey]);
                                $saveCategory = $transformedCategories->createOrUpdateCategory($this->source);
                                if (!$saveCategory) {
                                    throw new \Exception('Failed to save categories data');
                                }
                            }

                            // Also we need to create or update the authors data, since the Authors API not all have content articles
                            $author = $data['authors'][0];
                            $transformedAuthor = new TransformedAuthor(null, $author['name'], $author['uri'] ?? null);
                            $savedAuthor = $transformedAuthor->createOrUpdateAuthor($this->source);
                            if (!$savedAuthor) {
                                throw new \Exception('Failed to save authors data');
                            }
                            $transformedArticles = new TransformedArticle($data['uri'], json_encode([$data['authors'][0]['name']]) ?? null, json_encode($categoryString), clean($data['title']), 
                            htmlentities($data['body']), $data['image'] ?? null, $data['dateTime'], $data['url']);
                            $saveArticle = $transformedArticles->createOrUpdateArticle($this->source);
                            if (!$saveArticle) {
                                throw new \Exception('Failed to save articles data');
                            } 
                        }
                    }
            } else {
                throw new \Exception('Failed fetching data articles');
            }
            $articlesPage++;
        }

        return true;
    }
}