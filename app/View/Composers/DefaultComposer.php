<?php

namespace App\View\Composers;

use stdClass;
use Illuminate\Contracts\View\View;

class DefaultComposer
{
    public function compose(View $view)
    {
        $shared = new stdClass();

        $shared->visitor = auth()->check() ? auth()->user() : optional();
        $shared->viewName = $view->getName();

        view()->share([
            'shared' => $shared,
        ]);
    }
}
