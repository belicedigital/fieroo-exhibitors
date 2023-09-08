<?php

namespace Fieroo\Exhibitors\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Fieroo\Exhibitors\Models\Exhibitor;

class ExhibitorDetail extends Model
{
    use HasFactory;

    public $table = 'exhibitors_data';

    public function exhibitor()
    {
        return $this->belongsTo(Exhibitor::class);
    }
}
