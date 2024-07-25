<?php

namespace Fieroo\Exhibitors\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StandTypeCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'stand_type_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'category_id' => 'integer',
        'stand_type_id' => 'integer',
    ];

    public $table = 'stands_types_categories';
}
