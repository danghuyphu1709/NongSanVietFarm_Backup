<?php
namespace App\Enums;

enum TransferStatus: int
{
    // Đang xử lý -> Vận chuyển
    case READY_TO_PICK = 0;               // Mới tạo đơn hàng
    case PICKING = 1;                     // Nhân viên đang lấy hàng
    case MONEY_COLLECT_PICKING = 2;       // Đang thu tiền người gửi
    case PICKED = 3;                      // Nhân viên đã lấy hàng

    // Vận chuyển -> Giao hàng
    case STORING = 4;                     // Hàng đang nằm ở kho
    case TRANSPORTING = 5;                // Đang luân chuyển hàng
    case SORTING = 6;                     // Đang phân loại hàng hóa
    case DELIVERING = 7;                  // Nhân viên đang giao cho người nhận

    // Giao hàng -> Đã nhận hàng
    case MONEY_COLLECT_DELIVERING = 8;    // Nhân viên đang thu tiền người nhận
    case DELIVERED = 9;                  // Nhân viên đã giao hàng thành công

    // Hoàn thành (Nếu không có các status ở dưới)

    // Đã trả hàng
    case DELIVERY_FAIL = 10;              // Nhân viên giao hàng thất bại
    case WAITING_TO_RETURN = 11;          // Đang đợi trả hàng về cho người gửi
    case RETURN = 12;                     // Trả hàng
    case RETURN_TRANSPORTING = 13;        // Đang luân chuyển hàng trả
    case RETURN_SORTING = 14;             // Đang phân loại hàng trả
    case RETURNING = 15;                  // Nhân viên đang đi trả hàng
    case RETURN_FAIL = 16;                // Nhân viên trả hàng thất bại
    case RETURNED = 17;                   // Nhân viên trả hàng thành công
    case EXCEPTION = 18;                  // Đơn hàng ngoại lệ không nằm trong quy trình
    case DAMAGE = 19;                     // Hàng bị hư hỏng
    case LOST = 20;                       // Hàng bị mất

    // Đã hủy
    case CANCEL = 21;                     // Hủy đơn hàng
    
    public static function values(): array
    {
        return array_column(self::cases(), 'name', 'value');
    }

    public function label(): string
    {
        return match($this) {
            self::READY_TO_PICK => 'Mới tạo đơn hàng',
            self::PICKING => 'Nhân viên đang lấy hàng',
            self::MONEY_COLLECT_PICKING => 'Đang thu tiền người gửi',
            self::PICKED => 'Nhân viên đã lấy hàng',
            self::STORING => 'Hàng đang nằm ở kho',
            self::TRANSPORTING => 'Đang luân chuyển hàng',
            self::SORTING => 'Đang phân loại hàng hóa',
            self::DELIVERING => 'Nhân viên đang giao cho người nhận',
            self::MONEY_COLLECT_DELIVERING => 'Nhân viên đang thu tiền người nhận',
            self::DELIVERED => 'Nhân viên đã giao hàng thành công',
            self::DELIVERY_FAIL => 'Nhân viên giao hàng thất bại',
            self::WAITING_TO_RETURN => 'Đang đợi trả hàng về cho người gửi',
            self::RETURN => 'Trả hàng',
            self::RETURN_TRANSPORTING => 'Đang luân chuyển hàng trả',
            self::RETURN_SORTING => 'Đang phân loại hàng trả',
            self::RETURNING => 'Nhân viên đang đi trả hàng',
            self::RETURN_FAIL => 'Nhân viên trả hàng thất bại',
            self::RETURNED => 'Nhân viên trả hàng thành công',
            self::EXCEPTION => 'Đơn hàng ngoại lệ không nằm trong quy trình',
            self::DAMAGE => 'Hàng bị hư hỏng',
            self::LOST => 'Hàng bị mất',
            self::CANCEL => 'Hủy đơn hàng',
        };
    }
}
