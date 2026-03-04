<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Package;
use App\Models\PackageDetail;
use App\Models\PackageItinerary;

class PackageC extends Controller
{

  public function index($type = null)
  {
    $query = Package::with(['detail', 'itineraries']);

    // kalau type ada, filter
    if ($type) {
      $query->where('type', $type);
    }

    $packages = $query->paginate(9);

    return view('backend.paket.package', compact('packages', 'type'));
  }



  // Simpan paket baru
  public function store(Request $request, $type)
  {
    // Validasi type dulu
    if (!in_array($type, ['haji', 'umrah'])) {
      abort(404);
    }

    /*
    |--------------------------------------------------------------------------
    | Generate Auto Code
    |--------------------------------------------------------------------------
    */

    $prefix = $type === 'haji' ? 'HJI' : 'UMH';

    // Ambil kode terakhir berdasarkan type
    $lastPackage = Package::where('type', $type)
      ->where('code', 'like', $prefix . '-%')
      ->orderBy('id', 'desc')
      ->first();

    if ($lastPackage) {
      $lastNumber = (int) substr($lastPackage->code, -3);
      $newNumber = $lastNumber + 1;
    } else {
      $newNumber = 1;
    }

    $newCode = $prefix . '-' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);

    /*
    |--------------------------------------------------------------------------
    | Merge Data
    |--------------------------------------------------------------------------
    */

    $request->merge([
      'type' => $type,
      'code' => $newCode
    ]);

    /*
    |--------------------------------------------------------------------------
    | Validation
    |--------------------------------------------------------------------------
    */

    $request->validate([
      'name' => 'required|string',
      'slug' => 'required|string|unique:packages,slug',
      'price' => 'required|numeric|min:0',
      'price_triple' => 'required|numeric|min:0',
      'price_double' => 'required|numeric|min:0',
      'dp' => 'required|numeric|min:0',
      'quota' => 'required|integer|min:1',
      'departure_date' => 'required|date',
      'return_date' => 'required|date',
      'duration_days' => 'required|integer|min:1',
      'departure_city' => 'required|string',
      'destination_city' => 'required|string',
      'airline' => 'required|string',
      'hotel_makkah' => 'required|string',
      'hotel_madinah' => 'required|string',
      'hotel_rating' => 'required|integer',
      'status' => 'required|string',
    ]);

    Package::create($request->all());

    return redirect()->route('package.tabel', $type)
      ->with('success', 'Paket berhasil ditambahkan!');
  }



  // Update paket Haji
  public function update(Request $request, $type, $id)
  {
    $package = Package::where('type', $type)->findOrFail($id);

    $request->validate([
      'code' => "required|string|unique:packages,code,$id",
      'name' => 'required|string',
      'slug' => "required|string|unique:packages,slug,$id",
      'price' => 'required|numeric|min:0',
      'price_triple' => 'required|numeric|min:0',
      'price_double' => 'required|numeric|min:0',
      'dp' => 'required|numeric|min:0',
      'quota' => 'required|integer|min:1',
      'departure_date' => 'required|date',
      'return_date' => 'required|date',
      'duration_days' => 'required|integer|min:1',
      'departure_city' => 'required|string',
      'destination_city' => 'required|string',
      'airline' => 'required|string',
      'hotel_makkah' => 'required|string',
      'hotel_madinah' => 'required|string',
      'hotel_rating' => 'required|integer',
      'status' => 'required|string',
    ]);

    $package->update($request->all());

    return redirect()->route('package.tabel', $type)
      ->with('success', 'Paket berhasil diperbarui!');
  }

  public function delete($type, $id)
  {
    $package = Package::where('type', $type)->findOrFail($id);

    $package->detail()->delete();
    $package->itineraries()->delete();
    $package->delete();

    return redirect()->route('package.tabel', $type)
      ->with('success', 'Paket berhasil dihapus!');
  }

  public function toggleStatus($type, $id)
  {
    $package = Package::where('type', $type)->findOrFail($id);

    $next = match ($package->status) {
      'draft'     => 'published',
      'published' => 'closed',
      'closed'    => 'draft',
      default     => 'draft',
    };

    $package->update(['status' => $next]);

    return back()->with('success', "Status paket diubah ke \"{$next}\".");
  }

  public function view($type, $id)
  {
    $package = Package::where('type', $type)
      ->with(['detail', 'itineraries'])
      ->findOrFail($id);

    return view('backend.paket.view', compact('package', 'type'));
  }

  public function getNextCode($type)
  {
    if (!in_array($type, ['haji', 'umrah'])) {
      return response()->json(['code' => null]);
    }

    $prefix = $type === 'haji' ? 'HJI' : 'UMH';

    $lastPackage = Package::where('type', $type)
      ->where('code', 'like', $prefix . '-%')
      ->orderBy('id', 'desc')
      ->first();

    if ($lastPackage) {
      $lastNumber = (int) substr($lastPackage->code, -3);
      $newNumber = $lastNumber + 1;
    } else {
      $newNumber = 1;
    }

    $newCode = $prefix . '-' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);

    return response()->json([
      'code' => $newCode
    ]);
  }
}
