<?php namespace Bmartel\Transient;

use Illuminate\Support\ServiceProvider;

class TransientServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->package('bmartel/transient');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('Bmartel\Transient\TransientRepositoryInterface', 'Bmartel\Transient\TransientRepository');

        $this->app->bindShared('Bmartel\Transient\Service', function ($app) {
            return new Service($app['Bmartel\Transient\TransientRepositoryInterface']);
        });

        $this->commands('Bmartel\Transient\Console\CleanCommand');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array('transient');
    }

}
