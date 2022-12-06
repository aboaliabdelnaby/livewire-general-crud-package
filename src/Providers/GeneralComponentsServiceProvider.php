<?php

namespace LivewireComponents\GeneralComponents\Providers;
use Illuminate\Support\ServiceProvider;
use LivewireComponents\GeneralComponents\LivewireGeneralCrud;

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
        $this->publishes([
            __DIR__.'/../../src/Http/CrudComponents/' => app_path('App/Http'),
        ], 'CrudComponents');
    }
}
