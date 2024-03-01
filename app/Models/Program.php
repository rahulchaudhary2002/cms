<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'name',
        'university_id'
    ];

    public function university()
    {
        return $this->belongsTo(University::class);
    }

    public function assignPrograms()
    {
        return $this->hasMany(AssignProgram::class);
    }

    public function semesters()
    {
        return $this->hasMany(Semester::class);
    }
}
