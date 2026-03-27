<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CareerSkillRule extends Model
{
    protected $fillable = ['career_domain_id', 'skill_id', 'is_mandatory'];

    public function career()
    {
        return $this->belongsTo(CareerDomain::class, 'career_domain_id');
    }

    public function skill()
    {
        return $this->belongsTo(Skill::class);
    }
}

