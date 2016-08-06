<?php

namespace Vijaytupakula\Transvel;

use Illuminate\Support\ServiceProvider;

class TransvelServiceProvider extends ServiceProvider
{
     protected $commands = [
        'Vijaytupakula\Transvel\Translate',
    ];

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->commands($this->commands);
    }
}
