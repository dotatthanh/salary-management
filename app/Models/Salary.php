<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salary extends Model
{
    use HasFactory;

    protected $table = 'salary';

    protected $fillable = [
    	'user_id',
    	'paid_day_off',
    	'unpaid_day_off',
    	'total_days_off',
    	'total_working_days',
    	'salary',
    	'month',
        'year',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
