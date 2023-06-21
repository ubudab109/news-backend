<?php

namespace App\Repositories;

use App\Interfaces\CategoryInterface;
use Illuminate\Support\Facades\DB;

class CategoryRepository implements CategoryInterface
{
	/**
	 * Get categories data based on selected sources
	 * @param array $sourceId - Selected sources as array
	 * @return Collection
	 */
	public function getCategoryBySource(array $sourceId)
	{
		// We use DB builder for faster fetching
		$categories = DB::table('categories')
		->whereIn('source_id', $sourceId)
		->get();
		return $categories;
	}
}