<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    use HasFactory;
    public static function getCurrentDate()
    {
        $session = self::first();
        return $session ? $session->current_date : null;
    }
}
