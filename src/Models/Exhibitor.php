<?php

namespace Fieroo\Exhibitors\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Fieroo\Exhibitors\Models\ExhibitorDetail;

class Exhibitor extends Model
{
    use HasFactory;

    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'locale'
    ];

    public function detail()
    {
        return $this->hasOne(ExhibitorDetail::class);
    }
}
