<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;
use Illuminate\Support\Facades\Schema;
//use Illuminate\Support\Collection;
//use Illuminate\Pagination\Paginator;
//use Illuminate\Pagination\LengthAwarePaginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        Inertia::share('auth.user', function(){
            return Auth::user();
        });

        //Paginate on Collections

        /*if (!Collection::hasMacro('simplePaginate')) {

            Collection::macro('simplePaginate',
                function ($perPage = 15, $page = null, $options = []) {
                $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
                return (
                    new Paginator(
                        $this->forPage($page, $perPage),
                        $perPage,
                        $page,
                        $options
                    )
                )->withPath('');
            });
        }*/
    }
}
