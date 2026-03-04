<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\Jamaah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingC extends Controller
{
  public function create($type, $id)
  {
    $package = Package::with('detail')->findOrFail($id);

    return view('backend.paket.booking', compact('package'));
  }

  public function store(Request $request, $type, $id)
  {
    $package = Package::findOrFail($id);

    if ($package->quota_used >= $package->quota) {
      return back()->with('error', 'Kuota sudah penuh!');
    }

    $request->validate([
      'full_name' => 'required',
      'phone' => 'required',
      'room_type' => 'required|in:quad,triple,double'
    ]);

    DB::transaction(function () use ($request, $package) {

      $price = match ($request->room_type) {
        'quad' => $package->price,
        'triple' => $package->price_triple,
        'double' => $package->price_double,
      };

      Jamaah::create([
        'package_id' => $package->id,
        'registration_number' => 'REG-' . time(),
        'status' => 'pending',
        'departure_date' => $package->departure_date,
        'room_type' => $request->room_type,
        'price' => $price,
        'dp_amount' => $package->dp,
      ]);

      $package->increment('quota_used');
    });

    return redirect()->route('dashboard')
      ->with('success', 'Booking berhasil! Silakan lanjut pembayaran DP.');
  }
}
