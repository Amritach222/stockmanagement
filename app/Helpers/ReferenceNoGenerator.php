<?php

namespace App\Helpers;

use App\Models\Setting;
use Carbon\Carbon;

class ReferenceNoGenerator
{
    public static function referenceNo()
    {
        $currentDate = Carbon::now();
        $convertDate = new DateConverter();
        $nepDate = $convertDate->eng_to_nep($currentDate->format('Y'), $currentDate->format('m'), $currentDate->format('d'));
        $setting = Setting::findOrFail(1);
        if ($setting->fiscal_year_id) {
            $fiscalYear = $setting->fiscalYear;
            $fromDate = $fiscalYear->from;
            $toDate = $fiscalYear->to;
            $fromNepDate = $convertDate->eng_to_nep(Carbon::parse($fromDate)->format('Y'), Carbon::parse($fromDate)->format('m'), Carbon::parse($fromDate)->format('d'));
            $toNepDate = $convertDate->eng_to_nep(Carbon::parse($toDate)->format('Y'), Carbon::parse($toDate)->format('m'), Carbon::parse($toDate)->format('d'));
            $year = $fromNepDate['year'] % 1000 . '/' . $toNepDate['year'] % 100;
        } else {
            $year = $nepDate['year'] % 1000;
        }
        if ($nepDate['month'] < 10) {
            $month = '-0' . $nepDate['month'];
        } else {
            $month = '-' . $nepDate['month'];
        }
        $ref = $year . $month;
        return $ref;
    }
}
