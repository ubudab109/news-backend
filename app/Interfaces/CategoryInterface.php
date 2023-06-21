<?php

namespace App\Interfaces;

interface CategoryInterface
{
    /**
	 * Get categories data based on selected sources
	 * @param array $sourceId - Selected sources as array
	 * @return Collection
	 */
    public function getCategoryBySource(array $sourceId);
}