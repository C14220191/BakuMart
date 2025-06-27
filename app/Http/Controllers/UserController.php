<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Contracts\Support\ValidatedData;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Order;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('users.index', [
            'listUsers' => 'User'::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|unique:users,phone',
            'email' => 'required|string|email:dns|max:255|unique:users,email',
            'password' => 'required|min:5|confirmed',
        ]);
        User::create($validatedData);

        $request->session()->flash('success', 'Registration successful! Please login.');
        return redirect('/login');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Redirect berdasarkan role
            if (Auth::user()->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }
            return redirect()->route('home');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ]);
    }
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

    public function adminDashboard()
    {
        $orders = Order::with('user')
            ->whereHas('user', function ($q) {})
            ->orderBy('order_date', 'desc')
            ->get();

        $salesChart = DB::table('orders')
            ->select(DB::raw("TO_CHAR(order_date, 'Mon YYYY') as month"), DB::raw('SUM(total) as total_sales'))
            ->whereNotNull('order_date')
            ->whereIn('status', ['paid', 'completed', 'paid_cash']) // Sesuaikan status sukses di sistem kamu
            ->groupBy(DB::raw("TO_CHAR(order_date, 'Mon YYYY')"))
            ->orderBy(DB::raw("MIN(order_date)"))
            ->get();

        return view('admin.dashboard', compact('orders', 'salesChart'));
    }
}
