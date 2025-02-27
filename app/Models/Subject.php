<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{

  protected $guarded = [];

  // Relationships
  public function department()
  {
    return $this->belongsTo(Departments::class, 'department_id');
  }


  public function professor()
  {
    return $this->belongsTo(User::class, 'professor_id');
  }

  public function instructor()
  {
    return $this->belongsTo(User::class, 'instructor_id');
  }



  public function lectures()
  {
    return $this->hasMany(Lecture::class);
  }

  public function collegeYear()
  {
    return $this->belongsTo(CollegeYear::class);
  }


}
