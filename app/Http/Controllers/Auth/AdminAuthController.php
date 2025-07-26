<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\AdminUser;

class AdminAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $admin = AdminUser::where('username', $credentials['username'])
                         ->where('is_active', true)
                         ->first();

        if ($admin && password_verify($credentials['password'], $admin->password)) {
            Auth::guard('admin')->login($admin);
            return redirect()->intended(route('admin.dashboard'));
        }

        return back()->withErrors([
            'username' => 'Invalid credentials.',
        ]);
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('login');
    }
}
