<?php

namespace App\Enums;

use App\Models\User;
use Illuminate\Support\Collection;


enum  Roles: string
{
    case SYSTEM_ADMINISTRATOR = '1'; // Quản lý hệ thống

    case PRODUCT_MANAGE = '2'; // Quản lý sản phẩm

    case ACCOUNTANT = '3'; // Kế toán

    case SALESPERSON = '4'; // Nhân viên  bán hàng

    case WAREHOUSE_STAFF = '5'; // Nhân viên kho

    case CUSTOMER_SERVICE_REPRESENTATIVE = '6'; // Nhân viên chăm sóc khách hàng

    case ORDER_MANAGE = '7'; // Nhân viên quản lý đơn hàng

    case MARKETING = '8'; // Nhân viên tiếp thị
    case STATICTIS = '9'; // Báo cáo hệ thống
    case EMPLOYEE = '10'; // QUẢN LÝ NHÂN VIÊN
    case USER = '11'; // QUẢN LÝ khách hàng
    public static function values(): array
    {
        return array_column(self::cases(), 'name', 'value');
    }

    public function label(): string
    {
        return match($this) {
            self::SYSTEM_ADMINISTRATOR => 'Quản lý hệ thống',
            self::PRODUCT_MANAGE => 'Quản lý sản phẩm',
            self::ACCOUNTANT => 'Kế toán',
            self::SALESPERSON => 'Nhân viên  bán hàng',
            self::WAREHOUSE_STAFF => 'Nhân viên kho',
            self::CUSTOMER_SERVICE_REPRESENTATIVE => 'Nhân viên chăm sóc khách hàng',
            self::ORDER_MANAGE => 'Nhân viên quản lý đơn hàng',
            self::MARKETING => 'Nhân viên tiếp thị',
            self::STATICTIS => 'Báo cáo hệ thống',
            self::EMPLOYEE => 'Quản lý nhân viên',
            self::USER => 'Quản lý khách hàng',
        };
    }

    public static function allRoles(): array
    {
        $array = [];
        foreach (self::values() as $value => $name) {
            $array[] = $name;
        }
        return $array;
    }

    public static function admins() : Collection
    {
        $users = User::query()->get();
        $admins = $users->filter(function ($user) {
            return $user->hasAnyRole(self::allRoles());
        });
        return $admins;
    }


}