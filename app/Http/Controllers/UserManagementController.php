<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class UserManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        // Fetch all users with their associated categories
        // Paginate the results for better performance
        $users = User::with('categories');

        // Apply search filter if provided
        if (request()->has('search') && request()->input('search') !== '') {
            $search = request()->input('search');
            $users->where(function ($query) use ($search) {
                $query->where('name', 'like', '%'.$search.'%')
                    ->orWhere('email', 'like', '%'.$search.'%');
            });
        }

        // Apply role filter if provided
        if (request()->has('role') && request()->input('role') !== 'all' && request()->input('role') !== '') {
            $users->where('role', request()->input('role'));
        }

        // Apply category filter if provided
        if (request()->has('category_id') && request()->input('category_id') !== 'all' && request()->input('category_id') !== '') {
            $users->whereHas('categories', function ($query) {
                $query->where('categories.id', request()->input('category_id'));
            });
        }

        // Apply pagination
        $users = $users->latest()->paginate(request()->input('per_page', 5));
        $users->appends(request()->except('page')); // Preserve query parameters for pagination

        return view('admins.users.index', compact('users', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = \App\Models\Category::all();

        return view('admins.users.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validate = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,agent',
            'categories' => 'array',
        ]);

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'role' => $request->role,
            ]);
        } catch (\Exception $e) {
            Log::error('User creation failed: '.$e->getMessage());

            return redirect()->back()->with('error', Lang::get('Failed to create user. Please try again.'));
        }

        // sync categories if provided
        if ($request->has('categories')) {
            $user->categories()->sync($request->categories);
        }

        // send verification email if user is not an admin
        if ($user->role !== 'admin') {
            $user->sendEmailVerificationNotification();
        }

        // Check if inserted data is success
        return redirect()->route('admin.users.index')->with('success', Lang::get('User created successfully.'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::with('categories')->findOrFail($id);
        $categories = Category::all();

        return view('admins.users.show', compact('user', 'categories'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::with('categories')->findOrFail($id);
        $categories = \App\Models\Category::all();

        return view('admins.users.edit', compact('user', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $validate = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($user->id)],
            'role' => 'required|in:admin,agent',
            'categories' => 'array',
        ]);

        try {
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'role' => $request->role,
            ]);
        } catch (\Exception $e) {
            Log::error('User update failed: '.$e->getMessage());

            return redirect()->back()->with('error', Lang::get('Failed to update user. Please try again.'));
        }

        // Update password if provided
        if ($request->filled('password')) {
            // Validate password
            $request->validate([
                'password' => 'required|string|min:8|confirmed',
            ]);
            // Update the password
            $user->password = bcrypt($request->password);
            $user->save();
        }

        // sync categories if provided
        if ($request->has('categories')) {
            $user->categories()->sync($request->categories);
        }

        // Check if updated data is success
        return redirect()->route('admin.users.index')->with('success', Lang::get('User updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        // dd($user);
        try {
            $user->delete();

            return redirect()->route('admin.users.index')->with('success', Lang::get('User deleted successfully.'));
        } catch (\Exception $e) {
            Log::error('User deletion failed: '.$e->getMessage());

            return redirect()->back()->with('error', Lang::get('Failed to delete user. Please try again.'));
        }
    }
}
