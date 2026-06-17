<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentViolation extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'violation_id',
        'description',
        'points',
        'reported_at',
    ];

    protected $casts = [
        'reported_at' => 'date',
    ];

    protected static function booted()
    {
        static::saved(function ($studentViolation) {
            if ($studentViolation->student) {
                $studentViolation->student->update([
                    'points' => $studentViolation->student->studentViolations()->sum('points')
                ]);
            }
        });

        static::deleted(function ($studentViolation) {
            if ($studentViolation->student) {
                $studentViolation->student->update([
                    'points' => $studentViolation->student->studentViolations()->sum('points')
                ]);
            }
        });
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function violation()
    {
        return $this->belongsTo(Violation::class);
    }
}
