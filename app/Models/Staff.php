<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    use HasFactory;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users';
    protected $attributes = [
        'user_type_id' => 2,
    ];

    protected static function booted() {
        static::addGlobalScope('customer', function (Builder $builder) {
            $builder->where('user_type_id', 2);
        });
    }
}
