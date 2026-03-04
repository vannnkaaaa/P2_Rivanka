<?php

namespace App\Http\Controllers;

use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LandingpageC extends Controller
{
    public function index(Request $request, $type = null)
    {
        if (Auth::check()) {
            return match (Auth::user()->role) {
                'admin'  => redirect()->route('dashboard'),
                'agent'  => redirect()->route('agent.dashboard'),
                'jemaah' => redirect()->route('jemaah.dashboard'),
                default  => redirect()->route('landingpage'),
            };
        }

        // Query untuk Paket Haji (filter berdasarkan type haji)
        $hajiPackages = Package::where('status', 'published')
            ->where('type', 'haji')
            ->latest()
            ->paginate(6, ['*'], 'haji_page');


        // Query untuk Paket Umrah (filter berdasarkan type umrah)
        $umrahPackages = Package::where('status', 'published')
            ->where('type', 'umrah')
            ->latest()
            ->paginate(6, ['*'], 'umrah_page');

        return view('landingpage', compact('hajiPackages', 'umrahPackages'));
    }


    public function show($type, $slug)
    {
        $package = Package::where('slug', $slug)
            ->where('type', $type)
            ->where('status', 'published')
            ->with(['detail', 'itineraries'])
            ->firstOrFail();

        return view('landingpage-detail', compact('package'));
    }
}
