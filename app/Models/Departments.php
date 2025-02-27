<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Departments extends Model
{
  protected $guarded = [];

  // Relationships
  public function subjects()
  {
    return $this->hasMany(Subject::class, 'department_id');
  }






  public function users()
  {
    return $this->hasMany(User::class);
  }

}
