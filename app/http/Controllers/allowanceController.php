<?php

namespace App\Http\Controllers;

use App\Models\Allowance;
use Illuminate\Http\Request;

class AllowanceController extends Controller
{
    public function index()
    {
        $userID = auth()->id() ?? 1;

        $currentMonth = now()->format('Y-m');
        $lastMonth = now()->subMonth()->format('Y-m');

        $currentAllowance = Allowance::where('userID', $userID)
            ->whereRaw("DATE_FORMAT(month_year, '%Y-%m') = ?", [$currentMonth])
            ->sum('amount');

        $lastAllowance = Allowance::where('userID', $userID)
            ->whereRaw("DATE_FORMAT(month_year, '%Y-%m') = ?", [$lastMonth])
            ->sum('amount');

        $difference = $currentAllowance - $lastAllowance;

        if ($difference > 0) {
            $status = "▲ ₱" . number_format($difference, 2);
            $class = "increase";
        } elseif ($difference < 0) {
            $status = "▼ ₱" . number_format(abs($difference), 2);
            $class = "decrease";
        } else {
            $status = "No change";
            $class = "no-change";
        }

        return view('allowance.index', compact(
            'currentAllowance',
            'lastAllowance',
            'status',
            'class'
        ));
    }
}
