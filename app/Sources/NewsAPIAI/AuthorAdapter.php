<?php

namespace App\Sources\NewsApiAI;

use App\Sources\AbstractAuthorAdapter;
use App\Sources\TransformedAuthor;
use Illuminate\Http\Response;

class AuthorAdapter extends AbstractAuthorAdapter
{
    /**
     * Get the authors data from NewsAPI AI
     * Then save them to database
     * @return bool
     * @throws \Exception
     */
    public function createOrUpdateAuthors()
    {
        $reqParam = [
            'apiKey' => $this->source->key,
        ];

        $query = http_build_query($reqParam);
        $response = $this->client->request('get', 'suggestAuthorsFast?'. $query);
        $resItem = json_decode($response->getBody());
        if ($response->getStatusCode() == Response::HTTP_OK) {
            foreach($resItem as $data) {
                $transformedAuthor = new TransformedAuthor(null, $data->name, $data->uri);
                $saveAuthor = $transformedAuthor->createOrUpdateAuthor($this->source);
                if (!$saveAuthor) {
                    throw new \Exception('Failed to save authors data');
                }
            }
        } else {
            throw new \Exception('Failed fetching authors data');
        }

        return true;
    }
}