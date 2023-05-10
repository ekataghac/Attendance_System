<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Approval extends Model
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $fillable = [
        'status',
    ];
}
