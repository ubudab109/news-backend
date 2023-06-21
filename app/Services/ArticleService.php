<?php

namespace App\Services;

use App\Constants\PreferenceType;
use App\Http\Resources\PaginationResource;
use App\Interfaces\ArticleInterface;
use Illuminate\Support\Facades\Auth;

class ArticleService
{
    /** @var ArticleInterface */
    protected $article;

    public function __construct(ArticleInterface $article)
    {
        $this->article = $article;
    }

    /**
     * List for article news
     * Checking if user already set the preferences or not
     * @param array $param - Query param
     * @return array
     */
    public function listArticle(array $param)
    {
        $keyword = isset($param['keyword']) && !empty($param['keyword']) ? $param['keyword'] : null;
        $date = isset($param['date']) && !empty($param['date']) ? $param['date'] : null;
        if(Auth::check()) {
            $user = auth()->user();
            if($param['isParam']) {
                $sources = $param['sources'] ?? [];
                $authors = $param['authors'] ?? [];
                $categories = $param['categories'] ?? [];
            } else {
                $userSources = $user->preferenceType(PreferenceType::SOURCES());
                $sources = $userSources ? json_decode($userSources->data) : [];
                $userAuthors = $user->preferenceType(PreferenceType::AUTHORS());
                $authors = $userAuthors ? json_decode($userAuthors->data) : [];
                $userCategories = $user->preferenceType(PreferenceType::CATEGORIES());
                $categories = $userCategories ? json_decode($userCategories->data) : [];
            }
            $data = $this->article->getAllArticles(
                $keyword,
                $date,
                $categories,
                $sources,
                $authors,
            );
        } else {
            $data = $this->article->getAllArticles(
                $keyword,
                $date,
                isset($param['categories']) && !empty($param['categories']) ? $param['categories'] : [],
                isset($param['sources']) && !empty($param['sources']) ? $param['sources'] : [],
                isset($param['authors']) && !empty($param['authors']) ? $param['authors'] : [],
            );
        }

        $pagination = new PaginationResource($data);

        return [
            'success' => true,
            'message' => 'Articles fetched successfully',
            'data'    => $pagination,
        ];
    }
}