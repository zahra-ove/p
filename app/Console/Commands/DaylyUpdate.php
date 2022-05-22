<?php

namespace App\Console\Commands;

use App\Models\Order;
use App\Models\Takht;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class DaylyUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'day:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $orders=Order::with('takht')->where('status_order_id',1)->get();
        foreach ($orders as $order) {
            $unixraft = strtotime($order->raft);
            $unixbargasht = strtotime($order->bargasht);
            DB::beginTransaction();
            if ($unixraft <= time() && $unixbargasht > time()) {
                $takht = Takht::find($order->takht_id);
                $takht->status = 'پر';
                $takht->save();
            } elseif ($unixbargasht < time()) {

                $takht = Takht::find($order->takht_id);
                $takht->status = 'خالی';
                $takht->save();
                $order->status_order_id = 2;
                $order->save();
            }
        }
DB::commit();
    }
}
