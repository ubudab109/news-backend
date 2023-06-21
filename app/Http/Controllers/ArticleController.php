<?php

namespace App\Http\Controllers;

use App\Services\ArticleService;
use Illuminate\Http\Request;

class ArticleController extends BaseController
{
    /** @var ArticleService */
    private $services;

    /**
     * Constructor
     * @param ArticleService $services
     */
    public function __construct(ArticleService $services)
    {
        $this->services = $services;
    }

    /**
     * List of all articles
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $param = $request->only('keyword', 'date', 'sources', 'categories', 'authors', 'isParam');
        $articles = $this->services->listArticle($param);
        return $this->sendRespond($articles['data'], $articles['message']);
    }
}
