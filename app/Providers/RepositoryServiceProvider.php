<?php

namespace App\Providers;

use App\Interfaces\ArticleInterface;
use App\Interfaces\AuthorInterface;
use App\Interfaces\CategoryInterface;
use App\Interfaces\SourceInterface;
use App\Interfaces\UserInterface;
use App\Interfaces\UserPreferenceInterface;
use App\Repositories\ArticleRepository;
use App\Repositories\AuthorRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\SourceRepository;
use App\Repositories\UserPreferenceRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        /** INTERFACE AND REPOSITORY */
        $this->app->bind(UserPreferenceInterface::class, UserPreferenceRepository::class);
        $this->app->bind(AuthorInterface::class, AuthorRepository::class);
        $this->app->bind(CategoryInterface::class, CategoryRepository::class);
        $this->app->bind(SourceInterface::class, SourceRepository::class);
        $this->app->bind(ArticleInterface::class, ArticleRepository::class);
        $this->app->bind(UserInterface::class, UserRepository::class);
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
