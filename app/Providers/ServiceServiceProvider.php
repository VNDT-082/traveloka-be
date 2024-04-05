<?php

namespace App\Providers;

use App\Services\BaseService;
use App\Services\Hotel\HotelService;
use App\Services\IBaseService;
use App\Services\Hotel\IHotelService;
use App\Services\ImagesHotel\IImagesHotelService;
use App\Services\ImagesHotel\ImagesHotelService;
use Illuminate\Support\ServiceProvider;

class ServiceServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
        $this->app->bind(IBaseService::class, BaseService::class);

        $this->app->bind(IHotelService::class, HotelService::class);

        $this->app->bind(IImagesHotelService::class, ImagesHotelService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
