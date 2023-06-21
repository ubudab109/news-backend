<?php

namespace App\Sources\TheGuardian;

use App\Sources\AbstractArticleAdapter;
use App\Sources\TransformedArticle;
use App\Sources\TransformedAuthor;
use App\Sources\TransformedCategory;
use Illuminate\Http\Response;

class ArticleAdapter extends AbstractArticleAdapter
{

    /**
     * Get the article data from The Guardian
     * Then save them to database
     * @return bool
     * @throws \Exception
     */
    public function createOrUpdateArticle()
    {
        $page = 1;
        $param = [
            'api-key'     => $this->source->key,
            // currently, we only want fetch the articles from the start of June
            'from-date'   => '2023-06-01',
            'show-tags'   => 'contributor',
            'show-fields' => 'starRating,headline,thumbnail,short-url,body',
            'order-by'    => 'newest',
            'page-size'   => 100,
        ];

        // we want only fetch between 500-100 articles
        while($page <= 10) {
            $query = http_build_query($param);
            $request = $this->client->request('get', 'search?'. $query. '&page='. $page);
            $response = json_decode($request->getBody(), true)['response'];
            if($response['status'] == 'ok') {
                $results = $response['results'];
                foreach($results as $result) {
                    // We only save the articles that have author data
                    if(!empty($result['tags'])) {
                        /**
                         * We need to saving authors from article
                         * since the Authors API not all have content articles
                         */
                        $authors = [];
                        foreach($result['tags'] as $author) {
                            $authors[] = $author['webTitle'];
                            $transformedAuthor = new TransformedAuthor($author['id'], $author['webTitle'], null);
                            $saveAuthor = $transformedAuthor->createOrUpdateAuthor($this->source);
                            if(!$saveAuthor) {
                                throw new \Exception('Failed to save author data from The Guardian');
                            }
                        }

                        $category = [$result['sectionId']];
                        $transformedArticles = new TransformedArticle($result['id'], json_encode($authors), json_encode($category), $result['webTitle'],
                        $result['fields']['body'], $result['fields']['thumbnail'] ?? null, $result['webPublicationDate'], $result['webUrl']);
                        $saveArticle = $transformedArticles->createOrUpdateArticle($this->source);
                        if(!$saveArticle) {
                            throw new \Exception('Failed to saving articles from The Guardiang');
                        }
                    }
                    
                }
            }
            $page++;
        }

        return true;
    }
}