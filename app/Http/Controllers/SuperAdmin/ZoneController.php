<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Zone;
use Illuminate\Http\Request;

class ZoneController extends Controller
{
    public function index()
    {
        $zones = Zone::latest()->paginate(15);

        return view('super_admin.zones.index', compact('zones'));
    }

    public function create()
    {
        return view('super_admin.zones.create');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255|unique:zones']);
        Zone::create($request->all());

        return redirect()->route('super-admin.zones.index')->with('success', 'Zona berhasil ditambahkan.');
    }

    public function edit(Zone $zone)
    {
        return view('super_admin.zones.edit', compact('zone'));
    }

    public function update(Request $request, Zone $zone)
    {
        $request->validate(['name' => 'required|string|max:255|unique:zones,name,'.$zone->id]);
        $zone->update($request->all());

        return redirect()->route('super-admin.zones.index')->with('success', 'Zona berhasil diperbarui.');
    }

    public function destroy(Zone $zone)
    {
        $zone->delete();

        return redirect()->route('super-admin.zones.index')->with('success', 'Zona berhasil dihapus.');
    }
}
