<?php

namespace App\Sources\TheGuardian;

use App\Sources\AbstractCategoryAdapter;
use App\Sources\TransformedCategory;
use Illuminate\Support\Facades\Log;

class CategoryAdapter extends AbstractCategoryAdapter
{
    /**
     * Get the categories data from The Guardian
     * Then save them to database
     * @return bool
     * @throws \Exception
     */
    public function createOrUpdateCategories()
    {
        $param = [
            'api-key' => $this->source->key,
        ];
        $query = http_build_query($param);
        $request = $this->client->request('get', 'sections?'. $query);
        $response = json_decode($request->getBody())->response;
        if($response->status == 'ok') {
            $results = $response->results;
            foreach($results as $result) {
                $transformedCategories = new TransformedCategory($result->id, $result->webTitle);
                $saveCategory = $transformedCategories->createOrUpdateCategory($this->source);
                if(!$saveCategory) {
                    throw new \Exception('Failed saving categories from The Guardian API');
                }
            }
        }
        return true;
    }
}