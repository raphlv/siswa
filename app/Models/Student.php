<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'nisn',
        'name',
        'class',
        'gender',
        'points',
    ];

    public function studentViolations()
    {
        return $this->hasMany(StudentViolation::class);
    }

    public function violations()
    {
        return $this->belongsToMany(Violation::class, 'student_violations')
                    ->withPivot('id', 'description', 'points', 'reported_at')
                    ->withTimestamps();
    }
}
