<?php

namespace App\Repositories;

use App\Interfaces\ArticleInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ArticleRepository implements ArticleInterface
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
	public function getAllArticles($keyword = null, $date = null, $categories = [], $sources = [], $authors = [])
	{
		// We using DB Builder for faster fetching
		$data = DB::table('articles')
			->select('articles.*', 'sources.name as sources_name')
			->join('sources', 'sources.id', '=', 'articles.source_id')
			->when(!is_null($keyword), function ($query) use ($keyword) {
				$query->where('title', 'LIKE', '%' . $keyword . '%')
					->orWhere('content', 'LIKE', '%' . $keyword . '%');
			})
			->when(!is_null($date), function ($query) use ($date) {
				$query->whereDate('published_date', $date);
			})
			->where(function ($query) use ($categories, $authors, $sources) {
				$query->when(!empty($categories) && !is_null($categories[0]), function ($subQuery) use ($categories) {
					$subQuery->whereJsonContains('category', $categories[0]);
					for ($i = 1; $i < count($categories); $i++) {
						$subQuery->orWhereJsonContains('category', $categories[$i]);
					}
				})
				->when(!empty($authors) && !is_null($authors[0]), function ($query) use ($authors) {
					$query->whereJsonContains('author', $authors[0]);
					for ($i = 0; $i < count($authors); $i++) {
						$query->orWhereJsonContains('author', $authors[$i]);
					}
				})->when(!empty($sources) && !is_null($sources[0]), function ($subQuery) use ($sources) {
					$dataSource = [];
					foreach($sources as $source) {
						$dataSource[] = (int)$source;
					}
					$subQuery->whereIn('source_id', $sources);
				});
			})
			->orderBy('published_date', 'desc')
			->paginate(10);
		return $data;
	}
}
