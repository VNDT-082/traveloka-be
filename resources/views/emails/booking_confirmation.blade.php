<!DOCTYPE html>
<html>

<head>
    <title>Booking Confirmation</title>
    <link rel="stylesheet" href="css.css">

</head>

<body style="background-color: aliceblue; padding: 10px; border-radius:24px">
    <h1 style="font-weight: bolder;text-align: center;">Xác nhận đặt phòng</h1>
    <p style="font-weight: bolder;text-align: center;">Kính gửi: {{ $bookingDetails['guest']->Name }},</p>
    <p style="font-weight: bolder;text-align: center;"> Đơn đặt phòng của bạn với mã là {{ $bookingDetails['booking']->id }} đã được chấp thuận.</p>
    <p style="font-weight: bolder">Thông tin chi tiết:</p>
    <ul class="booking-details" style="padding:5px;border:1px solid #333; border-radius:20px; list-style: none;">
        <li style="display:flex; flex-direction: column; gap: 8px ; margin:5px"><img width="24" height="24" src="https://th.bing.com/th/id/OIP.-YM5lvHuipXUPDIOH1B89gHaHR?rs=1&pid=ImgDetMain" alt="" /> <span style="color:#000; font-weight:700">Hotel:</span> <span style="color:#000; font-weight:500">{{ $bookingDetails['hotel']->Name }}</span></li>
        <li style="display:flex; flex-direction: column; gap: 8px ; margin:5px"><img width="24" height="24" src="https://th.bing.com/th/id/OIP._y-rDVi5zEXMxgDkt9A7EgAAAA?rs=1&pid=ImgDetMain" alt="" /> <span style="color:#000; font-weight:700">Tên phòng:</span> <span style="color:#000; font-weight:500">{{ $bookingDetails['room']->RoomName }}</span></li>
        <li style="display:flex; flex-direction: column; gap: 8px ; margin:5px"> <img width="24" height="24" src="https://th.bing.com/th/id/OIP.ghGVb046ZwImIHAMulDttgHaHa?rs=1&pid=ImgDetMain" alt="" /><span style="color:#000; font-weight:700">Loại phòng:</span> <span style="color:#000; font-weight:500">{{ $bookingDetails['typeroom']->Name }}</span></li>
        <li style="display:flex; flex-direction: column; gap: 8px ; margin:5px"><img width="24" height="24" src="https://th.bing.com/th/id/OIP.c2zjxEiQYSo2iQ0SeXl9pQHaHL?rs=1&pid=ImgDetMain" alt="" /> <span style="color:#000; font-weight:700">Ngày nhận phòng:</span> <span style="color:#000; font-weight:500">{{ $bookingDetails['booking']->TimeRecive }}</span></li>
        <li style="display:flex; flex-direction: column; gap: 8px ; margin:5px"><img width="24" height="24" src="https://th.bing.com/th/id/OIP.c2zjxEiQYSo2iQ0SeXl9pQHaHL?rs=1&pid=ImgDetMain" alt="" /> <span style="color:#000; font-weight:700">Ngày trả phòng:</span> <span style="color:#000; font-weight:500">{{ $bookingDetails['booking']->TimeLeave }}</span></li>
    </ul>
    <img width="200" height="200" src="https://th.bing.com/th/id/R.0316460c19a3dcdb9f2193e98b39b0e2?rik=JrktFJJETGbg1g&pid=ImgRaw&r=0" alt="">
    <p class="thank-you">Thank you for booking with us!</p>
</body>

</html>