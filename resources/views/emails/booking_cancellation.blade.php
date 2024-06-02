<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Xác nhận hủy đặt phòng thành công</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }

        h1 {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        p {
            line-height: 1.5;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
        }
    </style>
</head>

<body>
    <h1>Xác nhận hủy đặt phòng thành công</h1>

    <p>Kính gửi {{$bookingDetails['booking']->guest_name}} ( {{$bookingDetails['booking']->email}}),</p>

    <p>Chúng tôi rất vui được xác nhận rằng yêu cầu hủy đặt phòng của bạn tại {{$bookingDetails['booking']->hotel_name}} đã được xử lý thành công.</p>

    <h2>Thông tin đặt phòng:</h2>

    <table>
        <tr>
            <th>Số xác nhận</th>
            <th>Tên khách</th>
            <th>Phòng đã đặt</th>
            <th>Ngày nhận phòng</th>
            <th>Ngày trả phòng</th>
            <th>Tổng số tiền</th>
        </tr>
        <tr>
            <td>{{$bookingDetails['booking']->id}}</td>
            <td>{{$bookingDetails['booking']->guest_name}}</td>
            <td>{{$bookingDetails['booking']->room_name}}</td>
            <td>{{$bookingDetails['booking']->TimeRecive}}</td>
            <td>{{$bookingDetails['booking']->TimeLeave}}</td>
            <td>{{$bookingDetails['booking']->Price}}</td>
        </tr>
    </table>

    <p><strong>Lưu ý:</strong></p>

    <ul>
        <li>Do bạn đã hủy đặt phòng trước [số ngày quy định] ngày so với ngày nhận phòng, bạn sẽ không bị tính phí hủy phòng.</li>
        <li>Khoản tiền thanh toán đã được hoàn trả về tài khoản ngân hàng của bạn. Quá trình hoàn tiền có thể mất đến [số ngày] ngày làm việc.</li>
    </ul>

    <p>Chúng tôi rất tiếc vì không thể chào đón bạn đến {{$bookingDetails['booking']->hotel_name}} trong lần này. Hy vọng bạn sẽ có cơ hội quay lại với chúng tôi trong tương lai.</p>

    <p>Trân trọng,</p>

    <p>{{$bookingDetails['booking']->hotel_name}}</p>
</body>

</html>