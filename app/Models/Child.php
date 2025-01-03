<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Child extends Model
{
    use HasFactory, HasUlids;

    protected $guarded = ['id'];

    public function getAgeAttribute()
    {
        return $this->birth_date ? Carbon::parse($this->birth_date)->diffInMonths(now()) : null;
    }

    public function guardian()
    {
        return $this->belongsTo(Guardian::class);
    }
}
