<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    protected $composers = [
        '*' => \App\View\Composers\DefaultComposer::class,
    ];

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerComposers();

        Paginator::defaultView('pagination::semantic-ui');
    }

    protected function registerComposers()
    {
        foreach ($this->composers as $view => $composer) {
            View::composer($view, $composer);
        }
    }
}
