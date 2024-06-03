<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UpdateRoomStatus extends Command
{
    protected $signature = 'room:update-status';
    protected $description = 'Update room status based on check-in and check-out dates';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $now = Carbon::now();

        DB::table('room')
            ->join('bookinghotel', 'room.id', '=', 'bookinghotel.RoomId')
            ->where('bookinghotel.TimeRecive', '<=', $now)
            ->where('bookinghotel.TimeLeave', '>=', $now)
            ->where('bookinghotel.State', 1) // Assuming '1' means confirmed
            ->update(['room.State' => 1]);

        DB::table('room')
            ->join('bookinghotel', 'room.id', '=', 'bookinghotel.RoomId')
            ->where('bookinghotel.TimeLeave', '<', $now)
            ->update(['room.State' => 0]);

        $this->info('Room status updated successfully.');
    }
}
