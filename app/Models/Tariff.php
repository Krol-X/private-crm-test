<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tariff extends Model
{
    use SoftDeletes;

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'ration_name',
        'cooking_day_before',
    ];

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
