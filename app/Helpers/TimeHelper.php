<?php

namespace App\Helpers;

use Carbon\Carbon;

class TimeHelper
{
    /**
     * Formats date.
     *
     * @param $date
     *
     * @return float
     */
    public static function blogFormattedDate($date)
    {
        if (Carbon::now()->startOfDay() < $date) {
            return __('Today at') . ' ' . $date->format('H:i');
        } elseif (Carbon::now()->subDays(7) < $date) {
            return $date->format('l H:i');
        }

        return $date->format('Y-m-d H:i');
    }
}
