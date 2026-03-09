<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index()
    {
        $companies = Company::latest()->paginate(15);

        return view('super_admin.companies.index', compact('companies'));
    }

    public function create()
    {
        return view('super_admin.companies.create');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255|unique:companies']);
        Company::create($request->all());

        return redirect()->route('super-admin.companies.index')->with('success', 'Perusahaan berhasil ditambahkan.');
    }

    public function edit(Company $company)
    {
        return view('super_admin.companies.edit', compact('company'));
    }

    public function update(Request $request, Company $company)
    {
        $request->validate(['name' => 'required|string|max:255|unique:companies,name,'.$company->id]);
        $company->update($request->all());

        return redirect()->route('super-admin.companies.index')->with('success', 'Perusahaan berhasil diperbarui.');
    }

    public function destroy(Company $company)
    {
        $company->delete();

        return redirect()->route('super-admin.companies.index')->with('success', 'Perusahaan berhasil dihapus.');
    }
}
