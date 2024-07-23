<?php

namespace App\Providers;

use App\Services\LambdaService;
use Illuminate\Support\ServiceProvider;
use App\Repositories\InvokeLambdaRepository;

class AppServiceProvider extends ServiceProvider
{
	/**
	 * Register any application services.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->singleton(InvokeLambdaRepository::class, function ($app) {
            return new InvokeLambdaRepository($app->make(LambdaService::class));
        });
	}

	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		//
	}
}
