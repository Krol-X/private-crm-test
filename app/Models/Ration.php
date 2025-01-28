<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ration extends Model
{
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'order_id',
        'cooking_date',
        'cooking_day_before',
        'delivery_date',
    ];
}
