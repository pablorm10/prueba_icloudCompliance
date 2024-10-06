<?php

namespace App\Services;

use Carbon\Carbon;
use DateTime;

class DateService
{
    const MONTHS_YEAR = [
        'Enero' => '01',
        'Febrero' => '02',
        'Marzo' => '03',
        'Abril' => '04',
        'Mayo' => '05',
        'Junio' => '06',
        'Julio' => '07',
        'Agosto' => '08',
        'Septiembre' => '09',
        'Octubre' => '10',
        'Noviembre' => '11',
        'Diciembre' => '12'
    ];

    public function generateRandomDate($minYear=2024, $maxYear=2024, $minMonth=1, $maxMonth=12, $minDay=1, $maxDay=31){
        // Generar una fecha aleatoria

        $minDate = Carbon::create($minYear, $minMonth, $minDay);
        $maxDate = Carbon::create($maxYear, $maxMonth, $maxDay);
        $randomDate = Carbon::createFromTimestamp(mt_rand($minDate->timestamp, $maxDate->timestamp));

        return $randomDate;

    }

    public function getMonthToDate($date){

        $dateTime = new DateTime($date);

        $month = $dateTime->format('m');

        return $month;
    }
}
