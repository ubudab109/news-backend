<?php

namespace App\Services;

use App\Interfaces\CategoryInterface;

class CategoryService
{
    /** @var CategoryInterface */
    protected $category;

    /**
     * Constructor
     * @param CategoryInterface
     */
    public function __construct(CategoryInterface $category)
    {
        $this->category = $category;
    }

    /**
     * Get categories data based on selected sources
     * @param array $sources
     * @return array
     */
    public function getCategoryBySources(array $sources)
    {
        $data = $this->category->getCategoryBySource($sources);
        return [
            'success' => true,
            'message' => 'Data Categories fetched successfully',
            'data'    => $data,
        ];
    }
}