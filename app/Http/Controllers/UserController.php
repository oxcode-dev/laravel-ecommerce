<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{
    public function index(Request $request)//: Response
    {
        // $users = User::search($request->get('search', ''))
        $users = User::with('')->where('role', 'CUSTOMER')->orderBy(
                $request->get('sortField', 'created_at'),
                $request->get('sortAsc') === 'true' ? 'asc' : 'desc'
            )    
            ->paginate($request->get('perPage', 5));

        return Inertia::render('users/index', [
            'status' => $request->session()->get('status'),
            'users' => $users,
        ]);
    }

    public function customers(Request $request)//: Response
    {
        // $users = User::search($request->get('search', ''))
        $users = User::where('role', 'VENDOR')->orderBy(
                $request->get('sortField', 'created_at'),
                $request->get('sortAsc') === 'true' ? 'asc' : 'desc'
            )    
            ->paginate($request->get('perPage', 5));

        return Inertia::render('users/index', [
            'status' => $request->session()->get('status'),
            'users' => $users,
        ]);
    }

    public function view(Request $request, User $user)//: Response
    {
        $user = $user::whereId($user->id)->firstOrFail();

        dd($user->toArray());

        return Inertia::render('users/show', [
            'status' => $request->session()->get('status'),
            'user' => $user,
        ]);
    }

    public function delete(Request $request, User $user)
    {
        $user = User::where('id', $user->user_id)->first();
        
        $user->delete();

        return redirect('/users')->with([
            'status' => $request->session()->get('status'),
        ]);
    }
}
