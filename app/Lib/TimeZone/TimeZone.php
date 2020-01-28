<?php

namespace App\Lib\TimeZone;

use Carbon\Carbon;
use DateTime;

class TimeZone
{
    public function toServer(string $input, int $offset, string $format = 'Y-m-d H:i:s'): ?string
    {
        if ($datetime = DateTime::createFromFormat($format, $input)) {
            $carbon = Carbon::instance($datetime);
            $carbon->addMinutes($offset);
            return $carbon->format($format);
        }
        return $input;
    }

    public function toClient(string $input, int $offset, string $format = 'Y-m-d H:i:s'): ?string
    {
        if ($datetime = DateTime::createFromFormat($format, $input)) {
            $carbon = Carbon::instance($datetime);
            $carbon->addMinutes(-$offset);
            return $carbon->format($format);
        }
        return $input;
    }
}
