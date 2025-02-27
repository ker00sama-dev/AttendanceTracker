<?php

namespace App\Http\Controllers;

use App\Helpers\Helpers;
use App\Models\Attendance;
use App\Models\Lecture;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class AttendanceQRController extends Controller
{
  /**
   * Handle the attendance scanning process.
   *
   * @param int $id
   * @return \Illuminate\Http\RedirectResponse
   */
  public function scan($id)
  {
    try {
      // Get the authenticated user's ID
      $user_id = auth()->id();

      Log::error('Error in attendance scan: ' . $id);



      // Attempt to record attendance
      $scan = self::doAttend($user_id, $id);

      // Display success message and redirect to home
      sweetalert()->success(__('Attendance recorded successfully!'));
      return redirect()->route('home');
    } catch (\Exception $e) {
      // Log the error for debugging
      Log::error('Error in attendance scan: ' . $e->getMessage());

      // Display error message and redirect to home
      sweetalert()->error($e->getMessage());
      return redirect()->route('home');
    }
  }

  public static function doAttend($user_id, $lecture_id) : void
  {
    try {
      // Validate lecture
      $lecture = Lecture::find($lecture_id);
      if (!$lecture || !$lecture instanceof \App\Models\Lecture) {
        throw new \Exception(__('Lecture not found.'));
      }

      // Validate user
      $user = User::find($user_id);
      if (!$user) {
        throw new \Exception(__('User not found.'));
      }

      // Current time and lecture start time
      $scanned_at = Carbon::now();
      $start_time = Carbon::parse($lecture->start_time);

      // Check if the scan is within 1 hour of the lecture's start time
      if ($scanned_at->diffInMinutes($start_time) > 60) {
        throw new \Exception(__('Attendance scan time exceeded. You cannot scan after 1 hour.'));
      }

      // Determine the attendance status
      $status = $scanned_at->diffInMinutes($start_time) <= 30 ? 'present' : 'late';

      // Check if the role is student
      if ($user->role !== 'student') {
        throw new \Exception(__('Only students can mark attendance.'));
      }

      // Check if attendance record already exists
      $attendance = Attendance::where('student_id', $user_id)->where('lecture_id', $lecture_id)->first();

      if ($attendance) {
        // You Are Already Marked Attendance
        throw new \Exception(__('You have already marked attendance.'));
      } else {
        // Create a new attendance record
        Attendance::create([
          'student_id' => $user_id,
          'lecture_id' => $lecture_id,
          'scanned_at' => $scanned_at,
          'status' => $status,
        ]);
      }
    } catch (\Exception $e) {
      // Log the error for debugging
      Log::error(__('Error in doAttend: :message', ['message' => $e->getMessage()]));

      // Rethrow the exception with the localized message
      throw new \Exception(__($e->getMessage()));
    }
  }

}
