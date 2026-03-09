<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Checkup\CheckupItem;
use Illuminate\Http\Request;

class CheckupItemController extends Controller
{
    public function index()
    {
        $items = CheckupItem::orderBy('item_number')->paginate(20);
        return view('super_admin.master.checkup.index', compact('items'));
    }

    public function create()
    {
        return view('super_admin.master.checkup.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'uraian' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'field_type' => 'required|in:text,dropdown,date,checklist,number',
            'options' => 'nullable|array',
            'urutan' => 'required|integer',
            'is_active' => 'boolean',
        ]);

        CheckupItem::create($request->all());

        return redirect()->route('super-admin.master.checkup.index')->with('success', 'Item Checkup berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $item = CheckupItem::findOrFail($id);
        return view('super_admin.master.checkup.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $item = CheckupItem::findOrFail($id);
        $request->validate([
            'uraian' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'field_type' => 'required|in:text,dropdown,date,checklist,number',
            'options' => 'nullable|array',
            'urutan' => 'required|integer',
            'is_active' => 'boolean',
        ]);

        $item->update($request->all());

        return redirect()->route('super-admin.master.checkup.index')->with('success', 'Item Checkup berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $item = CheckupItem::findOrFail($id);
        $item->delete();

        return redirect()->route('super-admin.master.checkup.index')->with('success', 'Item Checkup berhasil dihapus.');
    }
}
