<?php

namespace App\Sources\NewsApiAI;

use App\Sources\AbstractCategoryAdapter;
use App\Sources\TransformedCategory;
use Illuminate\Http\Response;

class CategoryAdapter extends AbstractCategoryAdapter
{
    /**
     * Get the categories data from NewsAPI AI
     * Then save them to database
     * @return bool
     * @throws \Exception
     */
    public function createOrUpdateCategories()
    {
        $reqParam = [
            'apiKey' => $this->source->key,
        ];

        $query = http_build_query($reqParam);
        $response = $this->client->request('get', 'suggestCategoriesFast?'. $query);
        $resItem = json_decode($response->getBody());
        if ($response->getStatusCode() == Response::HTTP_OK) {
            foreach($resItem as $data) {
                $transformedCategories = new TransformedCategory($data->uri, $data->label);
                $saveCategory = $transformedCategories->createOrUpdateCategory($this->source);
                if (!$saveCategory) {
                    throw new \Exception('Failed to save categories data');
                }
            }
        } else {
            throw new \Exception('Failed fetching categories data');
        }

        return true;
    }
}