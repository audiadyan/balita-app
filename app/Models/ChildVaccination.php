<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChildVaccination extends Model
{
    use HasFactory, HasUlids;

    protected $guarded = ['id'];

    public function child()
    {
        return $this->belongsTo(Child::class);
    }

    public function vaccine()
    {
        return $this->belongsTo(Vaccine::class);
    }
}
