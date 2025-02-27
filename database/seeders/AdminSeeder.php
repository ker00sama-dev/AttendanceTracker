<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {

    $collegeYears = [
      ['year_name' => 'First Year', 'description' => 'First year of college studies.'],
      ['year_name' => 'Second Year', 'description' => 'Second year of college studies.'],
      ['year_name' => 'Third Year', 'description' => 'Third year of college studies.'],
      ['year_name' => 'Fourth Year', 'description' => 'Fourth year of college studies.'],
    ];


    DB::table('college_years')->insert($collegeYears);
    /// Departments
    $departments = [
      ['name' => 'Computer Science', 'description' => 'Department of Computer Science.'],
      ['name' => 'Business Information Systems', 'description' => 'Department of Business Information Systems.'],
      ['name' => 'Business', 'description' => 'Department of Business.']
    ];
    DB::table('departments')->insert($departments);

    $department_id = DB::table('departments')->where('name', 'Business Information Systems')->first()->id;
    $college_year_id = DB::table('college_years')->where('year_name', 'Fourth Year')->first()->id;

    /// Subjects for 4th year Business Information Systems
    $subjects = [
      ['name' => 'مبادئ المالية العامة', 'description' => 'Introduction to Public Finance'],
      ['name' => 'مبادئ علم الاحصاء', 'description' => 'Principles of Statistics'],
      ['name' => 'تطبيقات في برامج الحاسب', 'description' => 'Applications in Computer Programs'],
      ['name' => 'أنظمة معلومات المؤسسات', 'description' => 'Enterprise Information Systems'],
      ['name' => 'نظم معلومات الكترونيه', 'description' => 'Electronic Information Systems'],
    ];


    //Found department_id from departments table


    User::create([
      'name' => 'Admin User',
      'email' => 'admin@admin.com',
      'password' => bcrypt('123456'),
      'role' => 'admin',
      'college_card_id' => '000000',
      'phone_number' => '+000000000000',
      'college_year_id' => $college_year_id,
      'department_id' => $department_id,
    ]);


    //Create professor Dr-Atef Raslan

    $professor = User::create([
      'name' => 'Dr-Atef Raslan',
      'email' => 'Atef@gmail.com',
      'password' => bcrypt('123456'),
      'role' => 'professor'
    ]);


    // SAVE SUBJECTS
    foreach ($subjects as $subject) {
      DB::table('subjects')->insert([
        'name' => $subject['name'],
        'description' => $subject['description'],
        'professor_id' => $professor->id, //Found professor_id from users table
        'department_id' => $department_id,
        'college_year_id' => $college_year_id,
      ]);
    }


  }
}
