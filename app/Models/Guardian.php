<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guardian extends Model
{
    use HasFactory, HasUlids;

    protected $guarded = ['id'];

    public function children()
{
    return $this->hasMany(Child::class);
}
}
