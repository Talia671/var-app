<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Checkup\CheckupDocument;
use App\Models\RegistrationToken;
use App\Models\Ujsimp\UjsimpTest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index(Request $request)
    {
        // Display users grouped by role
        $users = User::when($request->search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            })
            ->orderByRaw("FIELD(role, 'super_admin', 'admin_perijinan', 'checker_lapangan', 'avp', 'user')")
            ->orderBy('name')
            ->paginate(15);

        return view('super_admin.users.index', compact('users'));
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        
        // Find associated token
        $token = RegistrationToken::where('used_by', $id)->first();

        // Check UJSIMP status (Assuming linked by NPK or Name - simplistic approach if no direct relation)
        // Ideally User should have relation to UjsimpTest, but based on models, UjsimpTest has 'npk' and 'nama'
        // We will try to match by NPK if available, or name.
        // NOTE: User model does not have NPK column in fillable, but requirements mention NPK.
        // Assuming NPK might be stored in a separate profile or just using name/email for now as we cannot modify migration.
        // Wait, requirements say "Table columns: Name, NPK, Department, Role".
        // If User model doesn't have NPK, we might need to assume it's not there or check if it was added.
        // Checked User model: only name, email, password, role.
        // I will assume for now NPK is not directly on User, but maybe in related data or just not displayable if missing.
        // However, the prompt asks to display NPK. If it's not in DB, I can't display it from User model.
        // I'll check if there's any profile table.
        // No profile table seen in previous steps.
        // I will just display what is available and maybe try to find NPK from linked documents if possible.
        
        // Let's try to find latest UJSIMP and Checkup based on name since we don't have NPK in users table
        $ujsimp = UjsimpTest::where('nama', $user->name)->latest()->first();
        $checkup = CheckupDocument::where('nama_pengemudi', $user->name)->latest()->first();

        return view('super_admin.users.show', compact('user', 'token', 'ujsimp', 'checkup'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('super_admin.users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$id,
            'role' => 'required|in:super_admin,admin_perijinan,checker_lapangan,avp,user',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ]);

        return redirect()->route('super-admin.users.index')
            ->with('success', 'User updated successfully');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        // Prevent deleting self
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Cannot delete yourself');
        }

        // Safe delete - standard delete since SoftDeletes trait is not visible in User model
        $user->delete();

        return redirect()->route('super-admin.users.index')
            ->with('success', 'User deleted successfully');
    }
}
