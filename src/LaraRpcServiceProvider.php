<?php

namespace Fthi\LaraRpcRmq;


class LaraRpcServiceProvider extends \Illuminate\Support\ServiceProvider
{

    public function boot()
    {
        $this->offerPublishing();

        $this->registerCommands();
    }

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/rpc-client.php',
            'rpc-client'
        );


        $this->app->singleton('rmqClient', function ($app) {
            $logChannel = !empty($app['log']->channel('rpc')) ? $app['log']->channel('rpc') : $app['log']->channel('daily');
            return new SimpleClient($this->app['config']['rpc-client']['client'], $logChannel);
        });
    }

    protected function offerPublishing()
    {
        if (! function_exists('config_path')) {
            // function not available and 'publish' not relevant in Lumen
            return;
        }

        $this->publishes([
            __DIR__ . '/../config/rpc-client.php' => config_path('rpc-client.php'),
        ], 'config');
    }


    protected function registerCommands()
    {
        $this->commands([
            Commands\RpcServer::class
        ]);
    }
}
