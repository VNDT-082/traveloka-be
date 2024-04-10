<?php

namespace App\Providers;

use App\Repositories\AccountUser\AccountUserRepository;
use App\Repositories\AccountUser\IAccountUserRepository;
use App\Repositories\BaseRepository;
use App\Repositories\BookingHotel\BookingHotelRepository;
use App\Repositories\BookingHotel\IBookingHotelRepository;
use App\Repositories\ConvenientHotel\ConvenientHotelRepository;
use App\Repositories\ConvenientHotel\IConvenientHotelRepository;
use App\Repositories\Guest\GuestRepository;
use App\Repositories\Guest\IGuestRepository;
use App\Repositories\Hotel\HotelRepository;
use App\Repositories\IBaseRepository;
use App\Repositories\Hotel\IHotelRepository;
use App\Repositories\ImagesHotel\IImagesHotelRepository;
use App\Repositories\ImagesHotel\ImagesHotelRepository;
use App\Repositories\ListStaff\IListStaffRepository;
use App\Repositories\ListStaff\ListStaffRepository;
use App\Repositories\Message\IMessageRepository;
use App\Repositories\Message\MessageRepository;
use App\Repositories\PolicyHotel\IPolicyHotelRepository;
use App\Repositories\PolicyHotel\PolicyHotelRepository;
use App\Repositories\RateHotel\IRateHotelRepository;
use App\Repositories\RateHotel\RateHotelRepository;
use App\Repositories\Staff\IStaffRepository;
use App\Repositories\Staff\StaffRepository;
use App\Repositories\TypeRoom\ITypeRoomRepository;
use App\Repositories\TypeRoom\TypeRoomRepository;
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

        $this->app->bind(IAccountUserRepository::class, AccountUserRepository::class);

        $this->app->bind(IBookingHotelRepository::class, BookingHotelRepository::class);

        $this->app->bind(IConvenientHotelRepository::class, ConvenientHotelRepository::class);

        $this->app->bind(IGuestRepository::class, GuestRepository::class);

        $this->app->bind(IHotelRepository::class, HotelRepository::class);

        $this->app->bind(IImagesHotelRepository::class, ImagesHotelRepository::class);

        $this->app->bind(IListStaffRepository::class, ListStaffRepository::class);

        $this->app->bind(IMessageRepository::class, MessageRepository::class);

        $this->app->bind(IPolicyHotelRepository::class, PolicyHotelRepository::class);

        $this->app->bind(IRateHotelRepository::class, RateHotelRepository::class);

        $this->app->bind(IStaffRepository::class, StaffRepository::class);

        $this->app->bind(ITypeRoomRepository::class, TypeRoomRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}