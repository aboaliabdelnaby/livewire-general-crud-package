<?php

namespace CrudComponents\Providers;
use Illuminate\Support\ServiceProvider;
use CrudComponents\LivewireGeneralCrud;

class GeneralComponentsServiceProvider extends ServiceProvider
{
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
        if ($this->app->runningInConsole()) {
            $this->commands([
                LivewireGeneralCrud::class,
            ]);
        }
        //
//        $this->publishes([
//            __DIR__.'/../../src/CrudComponents/' => app_path('Http/CrudComponents'),
//        ], 'CrudComponents');
    }
}
