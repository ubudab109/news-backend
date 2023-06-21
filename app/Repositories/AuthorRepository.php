<?php

namespace App\Repositories;

use App\Interfaces\AuthorInterface;
use Illuminate\Support\Facades\DB;

class AuthorRepository implements AuthorInterface
{
	/**
	 * Get authors data based on selected sources
	 * @param array $sourceId - Selected sources as array
	 * @return Collection
	 */
	public function getAuthorBySource(array $sourceId)
	{
		// We use DB builder for faster fetching
		$authors = DB::table('authors')
		->select('source_id', 'name', 'external_id', 'email')
		->whereIn('source_id', $sourceId)
		->get();
		return $authors;
	}
}