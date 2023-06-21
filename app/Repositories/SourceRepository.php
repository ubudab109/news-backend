<?php

namespace App\Repositories;

use App\Interfaces\SourceInterface;
use App\Models\Source;

class SourceRepository implements SourceInterface
{
	/**
	 * @var Source
	 */
	protected $model;

	public function __construct(Source $model)
	{
		$this->model = $model;
	}

	/**
	 * List of sources
	 * 
	 * @return Collection
	 */
	public function listSources()
	{
		return $this->model->select('id as value', 'name as label')->get();
	}
}
