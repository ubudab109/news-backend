<?php

namespace App\Interfaces;

interface ArticleInterface
{
    /**
	 * Get all articles from database
	 * @param string|null $keyword
	 * @param string|null $date
	 * @param array|null $categories
	 * @param array|null $sources
	 * @param array|null $authors
	 * @return Collection
	 */
    public function getAllArticles($keyword = null, $date = null, $categories = [], $sources = [], $authors = []);
}