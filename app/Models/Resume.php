<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resume extends Model
{
    public $timestamps = false;

    protected $fillable = ['file_name', 'file_type', 'uploaded_at'];

    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'resume_skills');
    }
}

