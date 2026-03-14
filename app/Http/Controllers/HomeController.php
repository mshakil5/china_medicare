<?php

  namespace App\Http\Controllers;

  use Illuminate\Support\Facades\Auth;
  use Spatie\Activitylog\Models\Activity;
  use Carbon\Carbon;

class HomeController extends Controller
{
  public function dashboard()
  {
    if (Auth::check()) {
      $user = auth()->user();

      if ($user->user_type == '1') {
        return redirect()->route('admin.dashboard');
      } else if ($user->user_type == '0') {
        return redirect()->route('user.dashboard');
      }
    } else {
      return redirect()->route('login');
    }
  }

    public function adminHome()
    {

        $totalVisits = Activity::where('log_name', 'visitor-log')->count();

        // Count unique visitors today (by IP address stored in properties)
        $todaysUniqueVisitors = Activity::where('log_name', 'visitor-log')
            ->whereDate('created_at', Carbon::today())
            ->get()
            ->unique('properties.ip')
            ->count();
            
        return view('admin.pages.dashboard', compact('totalVisits', 'todaysUniqueVisitors' ));
    }

  public function userHome()
  {
    return 'user';
  }
}
