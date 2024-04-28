<?php

namespace App\Providers;

use App\Services\AccountUser\AccountUserService;
use App\Services\AccountUser\IAccountUserService;
use App\Services\BaseService;
use App\Services\BookingHotel\BookingHotelService;
use App\Services\BookingHotel\IBookingHotelService;
use App\Services\ConvenientHotel\ConvenientHotelService;
use App\Services\ConvenientHotel\IConvenientHotelService;
use App\Services\Guest\GuestService;
use App\Services\Guest\IGuestService;
use App\Services\Hotel\HotelService;
use App\Services\IBaseService;
use App\Services\Hotel\IHotelService;
use App\Services\ImagesHotel\IImagesHotelService;
use App\Services\ImagesHotel\ImagesHotelService;
use App\Services\ListStaff\IListStaffService;
use App\Services\ListStaff\ListStaffService;
use App\Services\Message\IMessageService;
use App\Services\Message\MessageService;
use App\Services\PolicyHotel\IPolicyHotelService;
use App\Services\PolicyHotel\PolicyHotelService;
use App\Services\Province\IProvinceService;
use App\Services\Province\ProvinceService;
use App\Services\RateHotel\IRateHotelService;
use App\Services\RateHotel\RateHotelService;
use App\Services\Room\IRoomService;
use App\Services\Room\RoomService;
use App\Services\Staff\IStaffService;
use App\Services\Staff\StaffService;
use App\Services\TypeRoom\ITypeRoomService;
use App\Services\TypeRoom\TypeRoomService;
use Illuminate\Support\ServiceProvider;

class ServiceServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(IBaseService::class, BaseService::class);

        $this->app->bind(IAccountUserService::class, AccountUserService::class);

        $this->app->bind(IBookingHotelService::class, BookingHotelService::class);

        $this->app->bind(IConvenientHotelService::class, ConvenientHotelService::class);

        $this->app->bind(IGuestService::class, GuestService::class);

        $this->app->bind(IHotelService::class, HotelService::class);

        $this->app->bind(IImagesHotelService::class, ImagesHotelService::class);

        $this->app->bind(IListStaffService::class, ListStaffService::class);

        $this->app->bind(IMessageService::class, MessageService::class);

        $this->app->bind(IPolicyHotelService::class, PolicyHotelService::class);

        $this->app->bind(IProvinceService::class, ProvinceService::class);

        $this->app->bind(IRateHotelService::class, RateHotelService::class);

        $this->app->bind(IRoomService::class, RoomService::class);

        $this->app->bind(IStaffService::class, StaffService::class);

        $this->app->bind(ITypeRoomService::class, TypeRoomService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
