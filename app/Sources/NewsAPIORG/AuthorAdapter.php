<?php

namespace App\Sources\NewsAPIORG;

use App\Sources\AbstractAuthorAdapter;
use App\Sources\TransformedAuthor;
use Illuminate\Http\Response;

class AuthorAdapter extends AbstractAuthorAdapter
{
    /**
     * Get the authors data from NewsAPI ORG
     * Then save them to database
     * @return bool
     * @throws \Exception
     */
    public function createOrUpdateAuthors()
    {
        $param = [
            'apiKey' => $this->source->key,
        ];
        $query = http_build_query($param);
        $request = $this->client->request('get', 'top-headlines/sources?'. $query);
        $response = json_decode($request->getBody(), true);
        if($response['status'] == 'ok') {
            $sources = $response['sources'];
            foreach($sources as $source) {
                $transformedAuthor = new TransformedAuthor($source['id'], $source['name'], null);
                $saveAuthor = $transformedAuthor->createOrUpdateAuthor($this->source);
                if(!$saveAuthor) {
                    throw new \Exception('Failed to save authors data from News Api Org');
                }
            }
        }
        return true;
    }
}