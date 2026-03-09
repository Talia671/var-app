<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Ranmor\RanmorField;
use Illuminate\Http\Request;

class RanmorFieldController extends Controller
{
    public function index()
    {
        $items = RanmorField::orderBy('urutan')->paginate(20);
        return view('super_admin.master.ranmor.index', compact('items'));
    }

    public function create()
    {
        return view('super_admin.master.ranmor.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'field_type' => 'required|in:text,dropdown,date,checklist,number',
            'options' => 'nullable|array',
            'urutan' => 'required|integer',
            'is_active' => 'boolean',
        ]);

        RanmorField::create($request->all());

        return redirect()->route('super-admin.master.ranmor.index')->with('success', 'Field Ranmor berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $item = RanmorField::findOrFail($id);
        return view('super_admin.master.ranmor.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $item = RanmorField::findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'field_type' => 'required|in:text,dropdown,date,checklist,number',
            'options' => 'nullable|array',
            'urutan' => 'required|integer',
            'is_active' => 'boolean',
        ]);

        $item->update($request->all());

        return redirect()->route('super-admin.master.ranmor.index')->with('success', 'Field Ranmor berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $item = RanmorField::findOrFail($id);
        $item->delete();

        return redirect()->route('super-admin.master.ranmor.index')->with('success', 'Field Ranmor berhasil dihapus.');
    }
}
