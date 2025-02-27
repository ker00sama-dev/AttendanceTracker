<?php

namespace App\Livewire\User;

use App\Helpers\Helpers;
use App\Http\Controllers\AttendanceQRController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;


class Home extends Component
{



  public $Count_Attendance = 0;
  public $Count_Subject = 0;
  public $Count_Lecture = 0;


  public function mount()
  {
    $user = Auth::user();

    // Handle attendance count
    $this->Count_Attendance = $user->attendances()->count() ?? 0;

    // Handle subject count, ensuring department is not null
    $this->Count_Subject = $user->department ? $user->department->subjects()->count() : 0;

    // Handle lecture count, ensuring department is not null

    $this->Count_Lecture = $user->department
      ? $user->department->subjects()->withCount('lectures')->get()->sum('lectures_count')
      : 0;


  }


  #[Title('Home')]
  public function render()
  {
    return view('livewire.user.home');
  }

  #[On('qrCodeScanned')]
  public function qrCodeScanned($data)
  {
    try {
      // Get the authenticated user's ID
      $user_id = auth()->id();

      // Check if data contains the required info (for example, an event or class ID)
      // Assuming $data is a URL or an ID string like 'https://attendance.kero-dev.tech/scan/1'
      // You may want to extract the ID from the URL (e.g., "1" in this case)
      if (preg_match('/scan\/(\d+)/', $data, $matches)) {
        $scan_id = $matches[1];  // Extracted ID from URL

        // Attempt to record attendance
        $scan = AttendanceQRController::doAttend($user_id, $scan_id);

        // Display success message and redirect to home
        sweetalert()->success(__('Attendance recorded successfully!'));

        return redirect()->route('home'); // Redirect after success
      } else {
        throw new \Exception('Invalid QR Code data.');
      }
    } catch (\Exception $e) {
      // Log the error for debugging purposes (optional)
      Log::error("QR Code Scan failed: " . $e->getMessage());


      sweetalert()->error($e->getMessage());
      return redirect()->route('home'); // Redirect after success

    }
  }

}
