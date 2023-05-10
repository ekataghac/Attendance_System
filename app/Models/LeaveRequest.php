<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\LeaveCategory;

class LeaveRequest extends Model
{
    use HasFactory;
    protected $fillable = [
        'start_date',
        'end_date',
        'reason',
        'status',
        
    ];

    //eloquent relationship between the leaveRequest, user nad leaveCategory
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function leaveCategory()
    {
        return $this->belongsTo(LeaveCategory::class, 'category_id');
    }


}
