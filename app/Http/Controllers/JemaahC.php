<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Jamaah;
use App\Models\JamaahGroup;
use App\Models\Package;
use App\Models\People;
use App\Models\Role;
use App\Models\User;

class JemaahC extends Controller
{
  public function index()
  {
    $users = User::with('userable')
      ->where('userable_type', People::class)
      ->get();

    $groups        = JamaahGroup::all();
    $packages      = Package::where('status', 'published')->get();
    $package_types = Package::where('status', 'published')
      ->distinct()
      ->pluck('type');

    return view('backend.people.jemaah.tabel', compact(
      'users',
      'groups',
      'packages',
      'package_types'
    ));
  }

  public function store(Request $request)
  {
    $request->validate([
      'username'              => 'required|unique:users,username',
      'email'                 => 'required|email|unique:users,email',
      'password'              => 'required|min:8|same:password_confirmation',
      'password_confirmation' => 'required',
      'fullname'              => 'required',
      'gender'                => 'required',
      'birth_place'           => 'required',
      'birth_date'            => 'required',
      'phone'                 => 'required',
      'address'               => 'required',
    ]);

    // Insert People
    $people = People::create([
      'fullname'    => $request->fullname,
      'gender'      => $request->gender,
      'birth_place' => $request->birth_place,
      'birth_date'  => $request->birth_date,
      'phone'       => $request->phone,
      'address'     => $request->address,
    ]);

    // Insert User
    $user = User::create([
      'username'      => $request->username,
      'email'         => $request->email,
      'password'      => Hash::make($request->password),
      'userable_id'   => $people->id,
      'userable_type' => People::class,
      'is_active'     => 1,
    ]);

    // Assign Role Jamaah
    $jamaahRole = Role::where('name', 'jamaah')->first();
    if ($jamaahRole) {
      $user->roles()->sync([$jamaahRole->id]);
    }

    // Tambah setelah assign role
    do {
      $reg_number = 'JMH-' . now()->format('Ymd') . '-' . strtoupper(Str::random(5));
    } while (Jamaah::where('registration_number', $reg_number)->exists());

    $authUser  = Auth::user();
    $authRoles = $authUser->roles->pluck('name')->toArray();
    $agentId   = in_array('agent', $authRoles) ? $authUser->userable?->id : null;

    Jamaah::create([
      'people_id'           => $people->id,
      'agent_id'            => $agentId,
      'registration_number' => $reg_number,
      'status'              => 'draft',
    ]);

    return redirect()->back()->with('success', 'Jemaah berhasil ditambahkan!');
  }

  public function update(Request $request, $id)
  {
    $user   = User::findOrFail($id);
    $people = $user->userable;

    $request->validate([
      'fullname'  => 'required|string|max:255',
      'phone'     => 'required|string|max:20',
      'address'   => 'nullable|string',
      'is_active' => 'required|in:0,1',
    ]);

    DB::beginTransaction();
    try {
      $people->update([
        'fullname' => $request->fullname,
        'phone'    => $request->phone,
        'address'  => $request->address,
      ]);

      $user->update([
        'is_active' => $request->is_active,
      ]);

      DB::commit();
      return redirect()->back()->with('success', 'Data jemaah berhasil diupdate!');
    } catch (\Exception $e) {
      DB::rollBack();
      return redirect()->back()->with('error', 'Gagal: ' . $e->getMessage());
    }
  }

  public function delete($id)
  {
    try {
      $user   = User::findOrFail($id);
      $people = $user->userable;
      $jamaah = Jamaah::where('people_id', $people->id)->first();

      if ($jamaah) $jamaah->delete();
      $user->delete();
      if ($people) $people->delete();

      return response()->json(['success' => true]);
    } catch (\Exception $e) {
      return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
    }
  }
}
