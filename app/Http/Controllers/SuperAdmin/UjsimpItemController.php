<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\UjsimpItem;
use Illuminate\Http\Request;

class UjsimpItemController extends Controller
{
    public function index()
    {
        $items = UjsimpItem::orderBy('urutan')->paginate(20);

        return view('super_admin.master.ujsimp.index', compact('items'));
    }

    public function create()
    {
        return view('super_admin.master.ujsimp.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'category' => 'required|string',
            'urutan' => 'required|integer',
            'uraian' => 'required|string',
            'field_type' => 'required|in:text,dropdown,date,checklist,number',
            'options' => 'nullable|array',
            'is_active' => 'boolean',
        ]);
        UjsimpItem::create($request->all());

        return redirect()->route('super-admin.master.ujsimp.index')->with('success', 'Item UJSIMP berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $item = UjsimpItem::findOrFail($id);

        return view('super_admin.master.ujsimp.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $item = UjsimpItem::findOrFail($id);
        $request->validate([
            'category' => 'required|string',
            'urutan' => 'required|integer',
            'uraian' => 'required|string',
            'field_type' => 'required|in:text,dropdown,date,checklist,number',
            'options' => 'nullable|array',
            'is_active' => 'boolean',
        ]);
        $item->update($request->all());

        return redirect()->route('super-admin.master.ujsimp.index')->with('success', 'Item UJSIMP berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $item = UjsimpItem::findOrFail($id);
        $item->delete();

        return redirect()->route('super-admin.master.ujsimp.index')->with('success', 'Item UJSIMP berhasil dihapus.');
    }
}
