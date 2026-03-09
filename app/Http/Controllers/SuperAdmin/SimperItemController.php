<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Simper\SimperItem;
use Illuminate\Http\Request;

class SimperItemController extends Controller
{
    public function index()
    {
        $items = SimperItem::orderBy('urutan')->paginate(20);
        return view('super_admin.master.simper.index', compact('items'));
    }

    public function create()
    {
        return view('super_admin.master.simper.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'field_type' => 'required|in:text,dropdown,date,checklist,number',
            'options' => 'nullable|array',
            'urutan' => 'required|integer',
            'is_active' => 'boolean',
        ]);

        SimperItem::create($request->all());

        return redirect()->route('super-admin.master.simper.index')->with('success', 'Field SIMPER berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $item = SimperItem::findOrFail($id);
        return view('super_admin.master.simper.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $item = SimperItem::findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'field_type' => 'required|in:text,dropdown,date,checklist,number',
            'options' => 'nullable|array',
            'urutan' => 'required|integer',
            'is_active' => 'boolean',
        ]);

        $item->update($request->all());

        return redirect()->route('super-admin.master.simper.index')->with('success', 'Field SIMPER berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $item = SimperItem::findOrFail($id);
        $item->delete();

        return redirect()->route('super-admin.master.simper.index')->with('success', 'Field SIMPER berhasil dihapus.');
    }
}
