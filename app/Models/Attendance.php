<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{

    protected $guarded = [];


    // Relationships
    public function lecture()
    {
        return $this->belongsTo(Lecture::class);
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id')->where('role', 'student');
    }

    // Scopes
    public function scopePresent($query)
    {
        return $query->where('status', 'present');
    }

    public function scopeAbsent($query)
    {
        return $query->where('status', 'absent');
    }

    public function scopeLate($query)
    {
        return $query->where('status', 'late');
    }

    public function collegeYear()
    {
        return $this->hasOneThrough(
            CollegeYear::class,
            User::class,
            'id', // Foreign key on users table
            'id', // Foreign key on college_years table
            'student_id', // Local key on attendances table
            'college_year_id' // Local key on users table
        );
    }

    public static function getAttendanceByYearAndSubject($collegeYearId, $subjectId, $status = null)
    {
        $query = self::query()
            ->whereHas('lecture.subject', function ($q) use ($collegeYearId, $subjectId) {
                $q->where('college_year_id', $collegeYearId)
                    ->where('id', $subjectId);
            });

        if ($status) {
            $query->where('status', $status);
        }

        return $query->with(['lecture', 'student'])->get();
    }

}
