<?php

namespace App\Listeners;

use App\Events\LoanApproved;
use App\Models\Payment;
use App\Services\PaymentScheduler;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SchedulePayment
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(LoanApproved $event): void
    {
        $schedule = PaymentScheduler::amount($event->loan->amount_required)
            ->tenure($event->loan->loan_term)
            ->loan_id($event->loan->id)
            ->runScheduler();
    }
}
