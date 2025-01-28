<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'client_name',
        'client_phone',
        'tariff_id',
        'schedule_type',
        'comment',
        'created_at',
        'first_date',
        'last_date',
    ];
}
