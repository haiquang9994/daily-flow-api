<?php

namespace App\Model;

class DailyFlow extends Base
{
    protected $table = 'daily_flow';

    protected $fillable = [
        'content',
    ];
}
