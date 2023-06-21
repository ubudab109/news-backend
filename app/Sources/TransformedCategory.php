<?php

namespace App\Sources;

use App\Models\Category;
use App\Models\Source;

class TransformedCategory
{
    public $externalId;
    public $label;

    /**
     * Transformed Category Constructor
     * @param string|null $externalId
     * @param string $label
     */
    public function __construct($externalId, $label)
    {
        $this->externalId = $externalId;
        $this->label = $label;
    }

    /**
     * Transform category data from external source then save to database
     * @param Source $source
     * @throws \Exception
     * @return Category
     */
    public function createOrUpdateCategory(Source $source)
    {
        $data = [
            'source_id'   => $source->id,
            'external_id' => $this->externalId,
            'label'       => $this->label,
        ];

        $savedCategories = $source->categories()->updateOrCreate($data, $data);

        if (is_bool($savedCategories)) {
            if (!$savedCategories) {
                throw new \Exception('Failed to create or update category data');
            }
            $category = $source->categories()->where($data);
        } else {
            $category = $savedCategories;
        }

        return $category;
    }
}