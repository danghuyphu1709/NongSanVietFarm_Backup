<?php

namespace App\Console\Commands;

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CancelExpiredOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:cancel-expired-orders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Hủy các đơn hàng đã hết hạn';

   public function __construct()
    {
        parent::__construct();
    }
    
    public function handle()
    {
        $expiredOrders = Order::where('expires_at', '<', Carbon::now())
                              ->where('status', PaymentStatus::PENDING_PAYMENT)
                              ->get();

        foreach ($expiredOrders as $order) {
            $order->status = OrderStatus::CANCELLED;
            $order->save();
        }

        $this->info('Các đơn hàng đã hết hạn đã được hủy.');
    }
}