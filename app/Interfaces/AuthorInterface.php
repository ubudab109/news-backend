<?php

namespace App\Interfaces;

interface AuthorInterface
{
    /**
	 * Get authors data based on selected sources
	 * @param array $sourceId - Selected sources as array
	 * @return Collection
	 */
    public function getAuthorBySource(array $sourceId);
}