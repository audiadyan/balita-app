<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;


class Guardian extends Model
{
    use HasFactory, HasUlids;

    protected $guarded = ['id'];

    public function getAgeAttribute()
    {
        return $this->birth_date ? Carbon::parse($this->birth_date)->diffInYears(now()) : null;
    }

    public function children()
    {
        return $this->hasMany(Child::class, 'mother_id')->orWhere('father_id', $this->id);
    }
}
