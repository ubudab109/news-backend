<?php

namespace App\Sources\TheGuardian;

use App\Sources\AbstractAuthorAdapter;
use App\Sources\TransformedAuthor;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class AuthorAdapter extends AbstractAuthorAdapter
{
    /**
     * Get the authors data from The Guardian AI
     * Then save them to database
     * @return bool
     * @throws \Exception
     */
    public function createOrUpdateAuthors()
    {
        $page = 1;
        $param = [
            'api-key'   => $this->source->key,
            'page-size' => 1000,
            'type'      => 'contributor',
        ];
        while($page <= 10) {
            $query = http_build_query($param);
            $request = $this->client->request('get', 'tags?'. $query. '&page='. $page);
            $response = json_decode($request->getBody(), true)['response'];
            if($response['status'] == 'ok') {
                $results = $response['results'];
                foreach($results as $result) {
                    $transformedAuthor = new TransformedAuthor($result['id'], $result['webTitle'], null);
                    $saveAuthor = $transformedAuthor->createOrUpdateAuthor($this->source);
                    if(!$saveAuthor) {
                        throw new \Exception('Failed to saving the author data from The Guardian');
                    }
                }   
            }
            $page++;
        }
        return true;
    }
}