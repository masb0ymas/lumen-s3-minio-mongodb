<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * @OA\Swagger(
 *     basePath="/",
 *     schemes={"http"},
 *     @OA\Info(
 *         version="0.0.1",
 *         title="Upload Service API",
 *     )
 * )
 */

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
}
