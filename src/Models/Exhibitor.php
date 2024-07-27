<?php

namespace Fieroo\Exhibitors\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Fieroo\Exhibitors\Models\ExhibitorDetail;
use Fieroo\Exhibitors\Models\Category;
use Fieroo\Bootstrapper\Models\User;
use Laravel\Cashier\Billable;

class Exhibitor extends Model
{
    use HasFactory, Billable;

    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'category_id',
        'locale',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'user_id' => 'integer',
        'category_id' => 'integer',
    ];

    public function detail()
    {
        return $this->hasOne(ExhibitorDetail::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
