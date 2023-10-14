<?php

namespace App\Services;

use App\Models\Loan;
use App\Models\Payment;

class PaymentScheduler
{
    public static $amount = 0;
    public static $tenure = 0;
    public static $loan_id = 0;

    public static function amount($amount) {
        static::$amount = $amount;

        return new static;
    }

    public static function tenure($tenure) {
        static::$tenure = $tenure;

        return new static;
    }

    public static function loan_id($loan_id) {
        static::$loan_id = $loan_id;

        return new static;
    }

    public static function runScheduler() {
        if($schedule = self::existPaymentSchedule(static::$loan_id)) {
            return $schedule;
        }

        $schedule = self::scheduler();

        Payment::insert($schedule);

        return $schedule;
    }

    private static function existPaymentSchedule($loan_id) {
        return Payment::where('loan_id', $loan_id)->get()->toArray();
    }

    private static function scheduler() {
        $scheduled = [];
        $weekCount = 1;

        $weeklyAmount = round(static::$amount / static::$tenure);
        $finalWeekAmount = static::$amount % static::$tenure;

        while($weekCount < static::$tenure) {
            $scheduled[] = [
                'loan_id' => static::$loan_id,
                'week' => $weekCount,
                'amount' => $weeklyAmount
            ];

            $weekCount++;
        }

        $scheduled[] = [
            'load_id' => static::$loan_id,
            'week' => static::$tenure,
            'amount' => $weeklyAmount + $finalWeekAmount
        ];

        return $scheduled;
    }
}
