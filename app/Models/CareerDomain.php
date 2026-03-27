<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CareerDomain extends Model
{
    protected $fillable = ['career_name', 'description'];

    public function rules()
    {
        return $this->hasMany(CareerSkillRule::class);
    }
}

