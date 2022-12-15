<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Payment;
use App\Models\Loan;
class Analytics extends Controller
{
  public function index()
  {
    $client_count = Client::count();
    $daily_collection = Payment::where('date',date('Y-m-d'))->sum('amount');
    $daily_collectibles = Loan::where('balance','<>', 0)->sum('principle_amount') / 100;
    $rem_collection = $daily_collectibles - $daily_collection;

    return view('content.dashboard.dashboards-analytics', compact('client_count','daily_collection','rem_collection'));
  }
}
