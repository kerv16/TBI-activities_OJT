<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activities extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'date_from',
        'date_to',
        'purpose',
        'conducted_by',
        'participants',
        'invitation_email',
        'reference_slip',
        't_o',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}