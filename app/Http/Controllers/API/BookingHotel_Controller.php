<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\MemberBookHotel_Model;
use App\Services\BookingHotel\IBookingHotelService;
use App\Services\Guest\IGuestService;
use App\Services\MemberBookHotel\IMemberBookHotelService;
use App\Services\Room\IRoomService;
use App\Services\SendMail\ISendMailService;
use DateTime;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Mockery\Undefined;
use Symfony\Component\VarDumper\VarDumper;

class BookingHotel_Controller extends Controller
{
    protected $IBookingHotelService;
    protected $IMemberBookHotelService;
    protected $IRoomService;
    protected $ISendMailService;
    protected $IGuestService;
    public function __construct(
        IBookingHotelService $IBookingHotelService,
        IMemberBookHotelService $IMemberBookHotelService,
        IRoomService $IRoomService,
        ISendMailService $ISendMailService,
        IGuestService $IGuestService
    ) {
        $this->IBookingHotelService = $IBookingHotelService;
        $this->IMemberBookHotelService = $IMemberBookHotelService;
        $this->IRoomService = $IRoomService;
        $this->ISendMailService = $ISendMailService;
        $this->IGuestService = $IGuestService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validatedData =  $request->validate([
                'id' => 'required',
                'GuestId' => 'required',
                'RoomId' => 'required',
                'ConfirmBy' => 'nullable',
                //'CreateDate' => 'required',
                'Price' => 'required',
                'Gift' => 'nullable',
                'Discount' => 'nullable',
                'State' => 'required',
                'Notes' => 'nullable',
                'TypePay' => 'required',
                'TimeRecive' => 'required',
                'TimeLeave' => 'required',
                'ConfirmAt' => 'nullable',
                'created_at' => 'required',
                'updated_at' => 'required',
            ]);
            $validatedCreateDate =  $request->validate(['CreateDate' => 'required']);
            $datetime = new DateTime($validatedCreateDate['CreateDate']);
            $validatedData['CreateDate'] = $datetime->format('Y-m-d H:i:s');

            if (isset($validatedData['ConfirmAt'])) {
                $conformAt = new DateTime($validatedData['ConfirmAt']);
                $validatedData['ConfirmAt'] = $conformAt->format('Y-m-d H:i:s');
            }

            $validatedData['State'] = $validatedData['State'] ? 1 : 0;
            $validatedDataMember = $request->validate(['members' => 'nullable']);

            DB::beginTransaction();
            $result = $this->IBookingHotelService->create($validatedData);
            if ($result) {
                if (count($validatedDataMember['members']) > 0) {
                    for ($i = 0; $i < count($validatedDataMember['members']); $i++) {
                        $member = $validatedDataMember['members'][$i];
                        var_dump($member);
                        if (isset($member['DateOfBirth'])) {
                            $DateOfBirth = new DateTime($member['DateOfBirth']);
                            $member['DateOfBirth'] = $DateOfBirth->format('Y-m-d');
                        }
                        $memberData = [
                            'id' => $member['id'],
                            'BookHotelId' =>  $result['id'],
                            'DateOfBirth' => $member['DateOfBirth'],
                            'FullName' => $member['FullName'],
                            'Sex' => $member['Sex'] ? 1 : 0,
                            'created_at' => $member['created_at'],
                            'updated_at' => $member['updated_at']
                        ];
                        $result_member = $this->IMemberBookHotelService->create($memberData);
                    }
                }
            }
            $result_updateStateRoom = $this->IRoomService->updateStateRoom($result['RoomId'], true);

            $room = $this->IRoomService->getOneById($result['RoomId']);
            $guest = $this->IGuestService->getOneById($result['GuestId']);

            $result_sendMail = $this->ISendMailService->sendMailNotifyToBuyer(
                $result,
                $guest['Name'],
                $room['typeroom']['Name'],
                $room['typeroom']['hotel']['Name'],
                $guest['Email']
            );
            $sendMailMessage = 'Gửi mail không thành công';
            if ($result_sendMail) {
                $sendMailMessage = 'Gửi mail thành công';
            }

            DB::commit();
            return response()->json([
                'message' => "Đã đặt phòng thành công thành công - " . $sendMailMessage,
                'status' => 'successfully',
                'result' => $validatedData
            ], 200);
        } catch (Exception $ex) {
            DB::rollBack();
            return response()->json([
                'message' => "Đặt phòng thất bại, vui lòng thử lại.",
                'status' => 'error',
                'data' => $validatedData,
                'result' => $ex
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
