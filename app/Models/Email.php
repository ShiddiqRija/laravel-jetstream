<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'from_name',
        'from_email',
        'subject',
        'body',
        'user_id',
    ];
}
