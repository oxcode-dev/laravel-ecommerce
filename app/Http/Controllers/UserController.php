<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;
use App\Models\User;
use App\Notifications\NewUserNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class UserController extends Controller
{
    public function index(Request $request)//: Response
    {
        $users = User::search($request->get('search', ''))
            ->where('role', 'ADMIN')->orderBy(
                $request->get('sortField', 'created_at'),
                $request->get('sortAsc') === 'true' ? 'asc' : 'desc'
            )    
            ->paginate($request->get('perPage', 5));

        return Inertia::render('users/index', [
            'status' => $request->session()->get('status'),
            'users' => $users,
            'page_type' => 'admin',
        ]);
    }

    public function vendors(Request $request)//: Response
    {
        $users = User::search($request->get('search', ''))
            ->where('role', 'VENDOR')->orderBy(
                $request->get('sortField', 'created_at'),
                $request->get('sortAsc') === 'true' ? 'asc' : 'desc'
            )    
            ->paginate($request->get('perPage', 5));

        return Inertia::render('users/index', [
            'status' => $request->session()->get('status'),
            'users' => $users,
            'page_type' => 'vendor',
        ]);
    }

    public function customers(Request $request)//: Response
    {
        $users = User::search($request->get('search', ''))
            ->where('role', 'CUSTOMER')->orderBy(
                $request->get('sortField', 'created_at'),
                $request->get('sortAsc') === 'true' ? 'asc' : 'desc'
            )    
            ->paginate($request->get('perPage', 5));

        return Inertia::render('users/index', [
            'status' => $request->session()->get('status'),
            'users' => $users,
            'page_type' => 'customer',
        ]);
    }

    public function view(Request $request, User $user)//: Response
    {

        $user = $user::with('products.category', 'orders.orderItems.product.user', 'addresses')->whereId($user->id)->firstOrFail();

        // dd($user->toArray());

        return Inertia::render('users/show', [
            'status' => $request->session()->get('status'),
            'user' => $user,
        ]);
    }

    public function create(Request $request)//: Response
    {
        return Inertia::render('users/form', [
            'status' => $request->session()->get('status'),
        ]);
    }

    public function store(Request $request)//: RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:'.User::class,
            'phone' => 'sometimes|string|max:255'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make('password'),
            'role' => 'ADMIN',
        ]);

        $user->fresh();

        $user->sendNewUserNotification();

        return redirect()->intended(route('users', absolute: false));
    }

    public function delete(Request $request, User $user)
    {
        $user = User::where('id', $user->id)->first();

        $user->products()->delete();

        $user->addresses()->delete();

        $user->orders()->delete();
        
        $user->delete();

        return redirect('/users')->with([
            'status' => $request->session()->get('status'),
        ]);
    }
}
