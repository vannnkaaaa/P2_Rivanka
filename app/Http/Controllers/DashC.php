<?php

namespace App\Http\Controllers;

use App\Models\Jamaah;
use App\Models\Agents;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashC extends Controller
{
  // ─────────────────────────────────────────
  // ADMIN DASHBOARD
  // ─────────────────────────────────────────
  public function admin()
  {
    $totalJemaah  = Jamaah::count();
    $totalAgent   = Agents::count();
    $totalPackage = Package::count();

    $jemaahLunas = Jamaah::whereHas('payments', function ($q) {
      $q->where('status', 'paid');
    })->count();

    $jemaahBelumLunas = $totalJemaah - $jemaahLunas;

    $recentJemaah = Jamaah::with(['people', 'payments', 'agent'])
      ->latest()
      ->take(10)
      ->get();

    $packages = Package::where('status', 'published')
      ->latest()
      ->take(10)
      ->get();

    return view('backend.dash', compact(
      'totalJemaah',
      'totalAgent',
      'totalPackage',
      'jemaahLunas',
      'jemaahBelumLunas',
      'recentJemaah',
      'packages'
    ));
  }

  // ─────────────────────────────────────────
  // AGENT DASHBOARD
  // ─────────────────────────────────────────
  public function agent()
  {
    $user    = Auth::user();
    $agent   = $user->userable; // App\Models\Agents via morphTo
    $agentId = $agent?->id ?? 0;

    $totalJemaah = Jamaah::where('agent_id', $agentId)->count();

    // Lunas = ada payment paid, dan tidak ada payment selain paid
    $jemaahLunas = Jamaah::where('agent_id', $agentId)
      ->whereHas('payments', fn($q) => $q->where('status', 'paid'))
      ->whereDoesntHave('payments', fn($q) => $q->where('status', '!=', 'paid'))
      ->count();

    $jemaahBelumLunas = $totalJemaah - $jemaahLunas;

    $paketAktif = Package::where('status', 'published')->count();

    $recentJemaah = Jamaah::with(['people', 'package', 'payments'])
      ->where('agent_id', $agentId)
      ->latest()
      ->take(10)
      ->get();

    $packages = Package::where('status', 'published')
      ->latest()
      ->take(6)
      ->get();

    return view('backend.dashboard.agen', compact(
      'agent',
      'totalJemaah',
      'jemaahLunas',
      'jemaahBelumLunas',
      'paketAktif',
      'recentJemaah',
      'packages'
    ));
  }

  // ─────────────────────────────────────────
  // JEMAAH DASHBOARD
  // ─────────────────────────────────────────
  public function jemaah()
  {
    $user     = Auth::user();
    $userable = $user->userable;

    // userable bisa People (dari register flow) atau Jamaah langsung
    if ($userable instanceof Jamaah) {
      $jamaah = $userable->load(['people', 'package', 'group', 'payments']);
    } else {
      // userable = People → cari Jamaah via people_id
      $jamaah = Jamaah::with(['people', 'package', 'group', 'payments'])
        ->where('people_id', $userable?->id)
        ->first();
    }

    $payments  = $jamaah?->payments ?? collect();
    $totalPaid = $payments->where('status', 'paid')->sum('amount');

    return view('backend.dashboard.jemaah', compact(
      'jamaah',
      'payments',
      'totalPaid'
    ));
  }
}
