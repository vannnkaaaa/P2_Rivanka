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
    $jamaahs       = Jamaah::with(['people', 'group', 'payments'])->get();
    $groups        = JamaahGroup::all();
    $packages = Package::where('status', 'published')->get();
    $package_types = Package::where('status', 'published')
      ->distinct()
      ->pluck('type');


    return view('backend.people.jemaah.tabel', compact('jamaahs', 'groups', 'packages', 'package_types'));
  }

  public function store(Request $request)
  {
    $request->validate([
      'username'              => 'required|string|unique:users,username',
      'email'                 => 'required|email|unique:users,email',
      'password'              => 'required|min:8|same:password_confirmation',
      'password_confirmation' => 'required',

      'fullname'              => 'required|string|max:255',
      'gender'                => 'required|in:L,P',
      'birth_place'           => 'required|string|max:255',
      'birth_date'            => 'required|date',
      'phone'                 => 'required|string|max:20',
      'address'               => 'required|string',

      'package_id'            => 'required|exists:packages,id',
      'departure_date'        => 'required|date',
      'status'                => 'required|in:draft,booked,paid,documents_verified,ready,departed',
      'group_id'              => 'nullable|exists:jamaah_groups,id',
    ]);

    DB::beginTransaction();

    try {

      $people = People::create([
        'fullname'    => $request->fullname,
        'gender'      => $request->gender,
        'birth_place' => $request->birth_place,
        'birth_date'  => $request->birth_date,
        'phone'       => $request->phone,
        'address'     => $request->address,
      ]);

      $user = User::create([
        'userable_id'   => $people->id,
        'userable_type' => People::class,
        'username'      => $request->username,
        'email'         => $request->email,
        'password'      => Hash::make($request->password),
        'is_active'     => 1,
      ]);

      $jamaahRole = Role::where('name', 'jamaah')->firstOrFail();
      $user->roles()->sync([$jamaahRole->id]); // lebih aman dari attach

      do {
        $reg_number = 'JMH-' . now()->format('Ymd') . '-' . strtoupper(Str::random(5));
      } while (Jamaah::where('registration_number', $reg_number)->exists());

      Jamaah::create([
        'people_id'           => $people->id,
        'agent_id'            => 1,
        'registration_number' => $reg_number,
        'departure_date'      => $request->departure_date,
        'package_id'          => $request->package_id,
        'group_id'            => $request->group_id,
        'status'              => $request->status,
      ]);

      DB::commit();

      return redirect()->back()->with('success', 'Jemaah berhasil ditambahkan!');
    } catch (\Exception $e) {
      DB::rollBack();
      return redirect()->back()->with('error', $e->getMessage());
    }
  }
}
