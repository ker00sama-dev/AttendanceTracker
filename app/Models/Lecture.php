<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lecture extends Model
{

  protected $guarded = [];



  // Relationships
  public function subject()
  {
    return $this->belongsTo(Subject::class);
  }

  public function creator()
  {
    return $this->belongsTo(User::class, 'created_by');
  }

  public function attendances()
  {
    return $this->hasMany(Attendance::class);
  }

  public function professor()
  {
    return $this->belongsTo(User::class, 'professor_id');
  }

  public function instructor()
  {
    return $this->belongsTo(User::class, 'instructor_id');
  }

  public function department()
  {
    return $this->belongsTo(Departments::class, 'department_id');
  }

  // Get Students of this lecture
  public function students()
  {
    return $this->belongsToMany(User::class, 'attendances', 'lecture_id', 'student_id');
  }


}
