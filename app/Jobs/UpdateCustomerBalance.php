<?php

namespace App\Jobs;

use App\Models\Customer;
use App\Models\CustomerPayment;
use App\Models\Sell;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateCustomerBalance implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Loop through each customer
        $customers = Customer::all();

        foreach ($customers as $customer) {
            // Get the total sales and payments for each customer
            $totalSales = Sell::where('customer_id', $customer->id)
                ->whereNull('deleted_at') // Optional: ensure no deleted records are included
                ->sum('net_total');

            $totalSalesPaid = Sell::where('customer_id', $customer->id)
                ->whereNull('deleted_at') // Optional: ensure no deleted records are included
                ->sum('paid_amount');

            $totalPayments = CustomerPayment::where('customer_id', $customer->id)
                ->whereNull('deleted_at') // Optional: ensure no deleted records are included
                ->sum('amount'); // Sum of all payments made by the customer

            // Calculate the new balance (total sales - total payments)
            $newBalance = ($totalPayments + $totalSalesPaid)- $totalSales;

            // Update the customer's balance
            $customer->balance = $newBalance;
            $customer->save();
        }
    }
}
