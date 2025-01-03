<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChildHealthRecord extends Model
{
    use HasFactory, HasUlids;

    protected $guarded = ['id'];

    public function getBmiStatusAttribute()
    {
        if ($this->bmi < 18.5) {
            return 'Kekurangan Gizi';
        } elseif ($this->bmi >= 18.5 && $this->bmi < 24.9) {
            return 'Normal';
        } elseif ($this->bmi >= 25 && $this->bmi < 29.9) {
            return 'Kelebihan Berat Badan';
        } else {
            return 'Obesitas';
        }
    }

    public function child()
    {
        return $this->belongsTo(Child::class);
    }
}
