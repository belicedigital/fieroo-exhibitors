<?php

namespace Fieroo\Exhibitors\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Fieroo\Exhibitors\Models\ExhibitorDetail;
use Fieroo\Bootstrapper\Models\User;
use Laravel\Cashier\Billable;

class Exhibitor extends Model
{
    use HasFactory, Billable;

    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'locale'
    ];

    public function detail()
    {
        return $this->hasOne(ExhibitorDetail::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
