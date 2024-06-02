<table style="border: 1px solid #25316C; border-collapse: collapse;" width="100%">
    <tbody>
        <tr>
            <td style="width: 80%; background-color: #25316C; color: white; padding-left: 5px;">
                <p><strong>Thông báo từ hệ đặt phòng khách sạn Finder</strong></p>
            </td>
            <td style=" background-color: #25316C"></td>
        </tr>
        <tr>
            <td colspan="2" style="width: 100%; padding: 5px;">
                [Hệ thống đặt phòng online - Finder] Thông báo đặt phòng thành công: {{ $model['id'] }}
                <br />
                <span style="font - size:12px;">
                    <span style="font-family:times new roman,times,serif;">
                        <span style="font - size:15px;"><strong>Dear
                                {{ $NameRecive }}</strong></span>
                        <br /><br />Bạn có đặt thành công phòng: {{ $model['RoomId'] }} (Khách sạn: {{ $hotelName }}
                        - {{ $typeRoomName }}) vào lúc {{ $model['created_at']->format('d/m/Y H:i:s') }}
                        <p style="line-height: 25px;"> Số ngày thuê: {{ $totalDay }} ngày
                            <br /> <strong>Giá : {{ number_format($model['Price'], 0, ',', '.') }} VNĐ
                                ({{ $model['TypePay'] }})
                            </strong><br /><strong>Ngày nhận phòng: </strong> {{ $model['TimeRecive'] }}
                            <br /> <strong>Ngày trả phòng: </strong> {{ $model['TimeLeave'] }}
                            <br /> <strong>Xem chi tiết phiếu đặt tại hệ thống</strong>
                            <br /> Email này được gửi tự động từ hệ thống đặt phòng online Finder - VIETNAM HOTEL FINDER
                            , vui lòng không reply.
                        </p>
            </td>
        </tr>
        <tr>
            <td style="width: 80%; background-color: #25316C; color: white; padding-left: 5px;">
                <p><strong>VIET NAM HOTEL FINDER</strong><strong><br /></strong>
                    <strong>Địa chỉ: 140 Lê Trọng Tấn, Tây Thạnh, Tân Phú, Thành phố Hồ Chí Minh.</strong>
                    <br /></strong>

                    <br /> <strong>Phone: 1900.000.000 </strong>- <strong>Email: vietnamhotelfinder.vn hoặc
                        info_vietnamhotelfinder@ktxhcm.edu.vn</strong><br />
                    <strong>Website:</strong> <a href="https://">https://</a>
                </p>
            </td>
            <td
                style="height: 100px; background-color: #25316C; font-size: 40px;text-align: center; color: aliceblue;
            font-weight: bold; padding: 10px">
                <span>FINDER</span>
                <span style=" background-color: #25316C; font-size: 10px;color: aliceblue; margin-top: -20px">VIETNAM
                    HOTEL FINDER</span>
            </td>
        </tr>
    </tbody>
</table>
<p>&nbsp;</p>
