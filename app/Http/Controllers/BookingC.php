<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\Jamaah;
use App\Models\People;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BookingC extends Controller
{
  public function index()
  {
    $user  = Auth::user();
    $roles = $user->roles->pluck('name')->toArray();

    if (in_array('agent', $roles)) {
      $agentId = $user->userable?->id;
      $jamaahs = Jamaah::with(['people', 'package', 'agent.people'])
        ->where('agent_id', $agentId)
        ->latest()
        ->get();
    } else {
      $jamaahs = Jamaah::with(['people', 'package', 'agent.people'])
        ->latest()
        ->get();
    }

    return view('backend.paket.booking_table', compact('jamaahs'));
  }

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
      'full_name'          => 'required|string',
      'phone'              => 'required|string',
      'room_type'          => 'required|in:quad,triple,double',
      'jamaah'             => 'required|array|min:1',
      'jamaah.*.name'      => 'required|string',
      'jamaah.*.phone'     => 'required|string',
    ]);

    $jamaahList = $request->jamaah;
    $sisa       = $package->quota - $package->quota_used;

    if (count($jamaahList) > $sisa) {
      return back()->with('error', "Kuota tidak cukup! Tersisa $sisa seat.");
    }

    $price = match ($request->room_type) {
      'quad'   => $package->price,
      'triple' => $package->price_triple,
      'double' => $package->price_double,
    };

    $authUser  = Auth::user();
    $authRoles = $authUser->roles->pluck('name')->toArray();
    $agentId   = in_array('agent', $authRoles) ? $authUser->userable?->id : null;
    $batchId = Str::uuid()->toString();

    DB::transaction(function () use ($request, $package, $jamaahList, $price, $agentId, $batchId) {
      foreach ($jamaahList as $jData) {
        do {
          $reg_number = 'JMH-' . now()->format('Ymd') . '-' . strtoupper(Str::random(5));
        } while (Jamaah::where('registration_number', $reg_number)->exists());

        $people = People::create(
          [
            'fullname' => $jData['name'],
            'phone'    => $jData['phone'],
          ]
        );

        Jamaah::create([
          'people_id'           => $people->id,
          'agent_id'            => $agentId,
          'package_id'          => $package->id,
          'registration_number' => $reg_number,
          'batch_id'            => $batchId,
          'status'              => 'booked',
          'departure_date'      => $package->departure_date,
        ]);

        $package->increment('quota_used');
      }
    });

    $authRoles = Auth::user()->roles->pluck('name')->toArray();
    if (in_array('agent', $authRoles)) {
      return redirect()->route('agent.dashboard')
        ->with('success', count($jamaahList) . ' jamaah berhasil dibooking!');
    } elseif (in_array('jemaah', $authRoles)) {
      return redirect()->route('jemaah.dashboard')
        ->with('success', 'Booking berhasil! Silakan lanjut pembayaran DP.');
    }

    return redirect()->route('admin.dashboard')
      ->with('success', count($jamaahList) . ' jamaah berhasil dibooking!');
  }

  public function updateStatus(Request $request, $id)
  {
    $request->validate([
      'status' => 'required|in:draft,booked,paid,documents_verified,ready,departed'
    ]);

    Jamaah::findOrFail($id)->update(['status' => $request->status]);

    return redirect()->back()->with('success', 'Status berhasil diupdate!');
  }

  public function show($id)
  {
    $jamaah = Jamaah::with([
      'people',
      'package',
      'group',
      'agent.people',
      'payments.paymentMethod',
      'documents',
      'health'
    ])->findOrFail($id);

    $batchJamaahs = collect();
    if ($jamaah->batch_id) {
      $batchJamaahs = Jamaah::with('people')
        ->where('batch_id', $jamaah->batch_id)
        ->get();
    }

    dd($jamaah->batch_id, $batchJamaahs->count());

    return view('backend.paket.booking_show', compact('jamaah', 'batchJamaahs'));
  }
}
