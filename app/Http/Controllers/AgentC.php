<?php

namespace App\Http\Controllers;

use App\Models\Agents;
use App\Models\Company;
use App\Models\People;
use App\Models\Association;
use App\Models\Agent;
use App\Models\Office;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AgentC extends Controller
{

  public function index()
  {
    $companies = Company::all();
    $associations = Association::all();
    $offices = Office::all();
    $agents = Agents::with('user.roles')->get();

    return view('backend.people.agent.tabel', compact('companies', 'associations', 'offices', 'agents'));
  }

  public function store(Request $request)
  {
    $request->validate([
      'fullname'       => 'required',
      'sex'            => 'required',
      'bod'            => 'required|date',
      'pob'            => 'required',
      'phone'          => 'required',
      'address'        => 'required',
      'company_id'     => 'required|exists:companies,id',
      'association_id' => 'nullable|exists:associations,id',
      'office_id'      => 'nullable|exists:offices,id', // baru
      'username'       => 'required|unique:users,username',
      'email'          => 'required|email|unique:users,email',
      'password'       => 'required|min:8|confirmed',
    ]);


    DB::transaction(function () use ($request) {

      // 1️⃣ Create People
      $people = People::create([
        'fullname'    => $request->fullname,
        'gender'      => $request->sex,
        'birth_date'  => $request->bod,
        'birth_place' => $request->pob,
        'phone'       => $request->phone,
        'address'     => $request->address,
      ]);

      // 2️⃣ Create Agent
      $agent = Agents::create([
        'company_id'          => $request->company_id,
        'association_id'      => $request->association_id,
        'people_id'           => $people->id,
        'office_id'           => $request->office_id, // baru
        'ppiu_license_number' => $request->ppiu_license_number,
        'pihk_license_number' => $request->pihk_license_number,
      ]);

      // 3️⃣ Create User (polymorphic) dan assign role
      $user = $agent->user()->create([
        'username' => $request->username,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'is_active' => $request->is_active,
        'email_verified_at' => now(),
      ]);

      // Assign role_id 2
      $user->roles()->attach(2);
    });

    return back()->with('success', 'Agent berhasil dibuat');
  }

  public function update(Request $request, $id)
  {
    $request->validate([
      'fullname'       => 'required',
      'sex'            => 'required',
      'phone'          => 'required',
      'address'        => 'required',
      'company_id'     => 'required|exists:companies,id',
      'association_id' => 'nullable|exists:associations,id',
      'office_id'      => 'nullable|exists:offices,id',
      'ppiu_license_number' => 'nullable|string',
      'pihk_license_number' => 'nullable|string',
      'password'       => 'nullable|min:8|confirmed',
      'is_active'      => 'required|boolean',
    ]);

    DB::transaction(function () use ($request, $id) {

      // Ambil agent
      $agent = Agents::findOrFail($id);

      // 1️⃣ Update People
      $people = $agent->people;
      $people->update([
        'fullname' => $request->fullname,
        'gender'   => $request->sex,
        'phone'    => $request->phone,
        'address'  => $request->address,
      ]);

      // 2️⃣ Update Agent
      $agent->update([
        'company_id'          => $request->company_id,
        'association_id'      => $request->association_id,
        'office_id'           => $request->office_id,
        'ppiu_license_number' => $request->ppiu_license_number,
        'pihk_license_number' => $request->pihk_license_number,
      ]);

      // 3️⃣ Update User
      $user = $agent->user;
      if ($user) {
        $user->is_active = $request->is_active;

        // Update password jika diisi
        if ($request->filled('password')) {
          $user->password = Hash::make($request->password);
        }

        $user->save();
      }
    });

    return back()->with('success', 'Data agen berhasil diperbarui');
  }

  public function destroy($id)
  {
    try {
      $agent = Agents::findOrFail($id);

      // Hapus user dan roles terkait (opsional)
      if ($agent->user) {
        $agent->user->roles()->detach();
        $agent->user->delete();
      }

      // Hapus people terkait (opsional)
      if ($agent->people) {
        $agent->people->delete();
      }

      // Hapus agent
      $agent->delete();

      return response()->json([
        'message' => 'Agent berhasil dihapus dari sistem'
      ], 200);
    } catch (\Exception $e) {
      return response()->json([
        'message' => 'Gagal menghapus agent: ' . $e->getMessage()
      ], 500);
    }
  }
}
