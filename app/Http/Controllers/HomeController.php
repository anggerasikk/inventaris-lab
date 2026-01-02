<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Borrowing;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        /** @var User|null $user */
        $user = Auth::user();

        $recentApprovals = collect();
        $upcomingReturns = collect();

        $userId = Auth::id();

        if ($userId !== null) {
            $recentApprovals = Borrowing::where('user_id', $userId)
                ->where('status', 'approved')
                ->where('updated_at', '>=', Carbon::now()->subDays(7))
                ->with('item')
                ->orderBy('updated_at', 'desc')
                ->limit(10)
                ->get();

            $upcomingReturns = Borrowing::where('user_id', $userId)
                ->where('status', 'approved')
                ->whereBetween('return_date', [Carbon::today(), Carbon::today()->addDays(7)])
                ->with('item')
                ->orderBy('return_date')
                ->get();
        }

        return view('home', compact('recentApprovals', 'upcomingReturns'));
    }
}
