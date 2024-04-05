<?php

namespace App\Providers;

use App\Repositories\BaseRepository;
use App\Repositories\Hotel\HotelRepository;
use App\Repositories\IBaseRepository;
use App\Repositories\Hotel\IHotelRepository;
use App\Repositories\ImagesHotel\IImagesHotelRepository;
use App\Repositories\ImagesHotel\ImagesHotelRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //dang ky BaseRepository
        $this->app->bind(IBaseRepository::class, BaseRepository::class);
        $this->app->bind(IHotelRepository::class, HotelRepository::class);

        $this->app->bind(IImagesHotelRepository::class, ImagesHotelRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
