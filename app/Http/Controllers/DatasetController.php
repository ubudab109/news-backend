<?php

namespace App\Http\Controllers;

use App\Services\AuthorService;
use App\Services\CategoryService;
use App\Services\SourceService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DatasetController extends BaseController
{
    /**
     * @var AuthorService|CategoryService|SourceService
     */
    private $authorService, $categoryService, $sourceService;

    public function __construct(AuthorService $authorService, CategoryService $categoryService, SourceService $sourceService)
    {
        $this->authorService = $authorService;
        $this->categoryService= $categoryService;
        $this->sourceService = $sourceService;
    }

    /**
     * Request get all sources
     * 
     * @return JsonResponse
     */
    public function getSources()
    {
        $data = $this->sourceService->listSources();
        return $this->sendRespond($data['data'], $data['message']);
    }

    /**
     * Request get authors or categories preference based on sources
     * @param Request $request
     * @return JsonResponse
     */
    public function getPreferences(Request $request)
    {
        if (!is_array($request->get('sources'))) {
            return $this->sendBadRequest('Failed', 'Sources must be type of array');
        }

        if ($request->type == 'authors') {
            $data = $this->authorService->getAuthorBySources($request->sources);
        } else if ($request->type == 'categories') {
            $data = $this->categoryService->getCategoryBySources($request->sources);
        } else {
            return $this->sendBadRequest('Failed', 'Type is required in "authors" or "categories"');
        }
        return $this->sendRespond($data['data'], $data['message']);
    }
}
