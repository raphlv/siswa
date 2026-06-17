<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Violation extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category',
        'points',
    ];

    public function studentViolations()
    {
        return $this->hasMany(StudentViolation::class);
    }

    public function students()
    {
        return $this->belongsToMany(Student::class, 'student_violations')
                    ->withPivot('id', 'description', 'points', 'reported_at')
                    ->withTimestamps();
    }
}
