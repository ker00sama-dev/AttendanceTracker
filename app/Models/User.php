<?php

namespace App\Models;

 use Illuminate\Contracts\Auth\MustVerifyEmail;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Propaganistas\LaravelPhone\Casts\E164PhoneNumberCast;

class User extends Authenticatable implements FilamentUser, MustVerifyEmail
{
  use HasApiTokens;

  /** @use HasFactory<\Database\Factories\UserFactory> */
  use HasFactory;
  use HasProfilePhoto;
  use Notifiable;
  use TwoFactorAuthenticatable;


  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */


  protected $fillable = [
    'name',
    'email',
    'password',
    'role',
    'college_card_id',
    'phone_number',
    'college_year_id',
    'department_id',
  ];


  public $casts = [
    'phone_number' => E164PhoneNumberCast::class . ':EG',
  ];
  /**
   * The attributes that should be hidden for serialization.
   *
   * @var array<int, string>
   */
  protected $hidden = [
    'password',
    'remember_token',
    'two_factor_recovery_codes',
    'two_factor_secret',
  ];

  /**
   * The accessors to append to the model's array form.
   *
   * @var array<int, string>
   */
  protected $appends = [
    'profile_photo_url',
  ];

  /**
   * Get the attributes that should be cast.
   *
   * @return array<string, string>
   */
  protected function casts(): array
  {
    return [
      'email_verified_at' => 'datetime',
      'password' => 'hashed',
    ];
  }

  public function canAccessPanel(Panel $panel): bool
  {
    return match ($panel->getId()) {
      'admin' => $this->role == 'admin',
      default => false,
    };
  }





  // Relationships



  //departments
  public function department()
  {
    return $this->belongsTo(Departments::class);
  }


  public function subjectsAsProfessor()
  {
    return $this->hasMany(Subject::class, 'professor_id');
  }

  public function subjectsAsInstructor()
  {
    return $this->hasMany(Subject::class, 'instructor_id');
  }

  public function createdLectures()
  {
    return $this->hasMany(Lecture::class, 'created_by');
  }

  public function attendances()
  {
    return $this->hasMany(Attendance::class, 'student_id');
  }

  // Scopes
  public function scopeStudents($query)
  {
    return $query->where('role', 'student');
  }

  public function scopeProfessors($query)
  {
    return $query->where('role', 'professor');
  }

  public function scopeInstructors($query)
  {
    return $query->where('role', 'instructor');
  }

  public function collegeYear()
  {
    return $this->belongsTo(CollegeYear::class);
  }



  public function isAdmin()
  {
    $adminRoles = [ 'admin', 'professor','instructor']; // Extend roles as needed
    return in_array($this->role, $adminRoles, true);
  }

  // Count of Attendance




}
