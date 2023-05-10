<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceRecord extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'date',
        'status',
        'check_in',
        'check_out',
        'remarks',
        
    ];

    //eloquent relationship defined between the user and the attendance_record table

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
