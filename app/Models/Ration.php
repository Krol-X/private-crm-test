<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
