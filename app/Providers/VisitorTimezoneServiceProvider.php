<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;
use App\Exceptions\UnknownVisitorTimezoneException;

class VisitorTimezoneServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Request::macro('toVisitorTimezone', function (Carbon $timestamp) {
            $timezone = $this->cookie('__timezone') ?? ($this->get('__timezone') ?? $this->header('timezone'));

            if (empty($timezone)) {
                throw new UnknownVisitorTimezoneException();
            }

            return (clone $timestamp)->timezone($timezone);
        });
    }
}
