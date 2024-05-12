<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activities extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'Date_from',
        'Date_to',
        'purpose',
        'conducted_by',
        'participants',
        'invitation_email',
        'reference_slip',
        't_o',
        'TBI_Activity',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}