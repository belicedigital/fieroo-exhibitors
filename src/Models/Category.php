<?php

namespace Fieroo\Exhibitors\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'is_active',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'slug' => 'string',
        'is_active' => 'boolean',
    ];

    public function exhibitor()
    {
        return $this->hasOne(Exhibitor::class);
    }
}
